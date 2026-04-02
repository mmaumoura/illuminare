<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(Request $request): View
    {
        $userClinicId = auth()->user()->clinicScope();

        $query = StockMovement::with(['product', 'clinic', 'user'])
            ->when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))
            ->orderByDesc('created_at');

        if ($search = $request->input('search')) {
            $query->whereHas('product', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $clinics   = $userClinicId ? Clinic::where('id', $userClinicId)->get() : Clinic::orderBy('name')->get();
        $movements = $query->paginate(25)->withQueryString();
        return view('estoque.index', compact('movements', 'clinics', 'userClinicId'));
    }

    public function create(Request $request): View
    {
        $userClinicId  = auth()->user()->clinicScope();
        $products      = Product::where('status', 'Ativo')->orderBy('name')->get();
        $clinics       = $userClinicId ? Clinic::where('id', $userClinicId)->get() : Clinic::where('active', true)->orderBy('name')->get();
        $selectedProduct = $request->input('product_id')
            ? Product::with('clinics')->find($request->input('product_id'))
            : null;
        return view('estoque.create', compact('products', 'selectedProduct', 'clinics', 'userClinicId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'clinic_id'  => 'required|exists:clinics,id',
            'type'       => 'required|in:Entrada,Saída,Ajuste',
            'quantity'   => 'required|integer|min:1',
            'unit_value' => 'nullable|numeric|min:0',
            'reason'     => 'required|string|max:255',
            'notes'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            $stockBefore = $product->stock_current;
            $qty = (int) $validated['quantity'];

            $stockAfter = match ($validated['type']) {
                'Entrada' => $stockBefore + $qty,
                'Saída'   => max(0, $stockBefore - $qty),
                'Ajuste'  => $qty,
                default   => $stockBefore,
            };

            $clinicId = auth()->user()->clinicScope() ?? $validated['clinic_id'];

            StockMovement::create([
                'product_id'   => $product->id,
                'clinic_id'    => $clinicId,
                'user_id'      => auth()->id(),
                'type'         => $validated['type'],
                'quantity'     => $validated['type'] === 'Saída' ? -$qty : $qty,
                'unit_value'   => $validated['unit_value'] ?? null,
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
                'reason'       => $validated['reason'],
                'notes'        => $validated['notes'] ?? null,
            ]);

            $product->update(['stock_current' => $stockAfter]);
        });

        return redirect()->route('comercial.estoque.index')
            ->with('success', 'Movimentação registrada com sucesso.');
    }
}
