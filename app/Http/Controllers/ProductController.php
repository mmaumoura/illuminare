<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    private function rules(?int $id = null): array
    {
        return [
            'code'           => 'nullable|string|max:50|unique:products,code' . ($id ? ",{$id}" : ''),
            'name'           => 'required|string|max:255',
            'category'       => 'nullable|string|max:100',
            'brand'          => 'nullable|string|max:100',
            'supplier'       => 'nullable|string|max:100',
            'cost_price'     => 'nullable|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock_current'  => 'nullable|integer|min:0',
            'stock_minimum'  => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
            'controls_stock' => 'nullable|boolean',
            'status'         => 'required|in:Ativo,Inativo',
            'clinics'        => 'required|array|min:1',
            'clinics.*'      => 'exists:clinics,id',
        ];
    }

    public function index(Request $request): View
    {
        $query = Product::with('clinics')->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(25)->withQueryString();
        return view('produtos.index', compact('products'));
    }

    public function create(): View
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('produtos.create', compact('clinics'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $clinicIds = $validated['clinics'];
        unset($validated['clinics']);

        $validated['controls_stock'] = $request->boolean('controls_stock');
        $validated['stock_current']  = $validated['stock_current'] ?? 0;
        $validated['stock_minimum']  = $validated['stock_minimum'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }
        unset($validated['image']);

        $product = Product::create($validated);
        $product->clinics()->sync($clinicIds);

        return redirect()->route('comercial.produtos.show', $product)
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function show(Product $produto): View
    {
        $produto->load('clinics', 'stockMovements.user');
        return view('produtos.show', ['product' => $produto]);
    }

    public function edit(Product $produto): View
    {
        $clinics = Clinic::orderBy('name')->get();
        $selectedClinicIds = $produto->clinics->pluck('id')->toArray();
        return view('produtos.edit', [
            'product'          => $produto,
            'clinics'          => $clinics,
            'selectedClinicIds'=> $selectedClinicIds,
        ]);
    }

    public function update(Request $request, Product $produto): RedirectResponse
    {
        $validated = $request->validate($this->rules($produto->id));
        $clinicIds = $validated['clinics'];
        unset($validated['clinics']);

        $validated['controls_stock'] = $request->boolean('controls_stock');

        if ($request->hasFile('image')) {
            if ($produto->image_path) {
                Storage::disk('public')->delete($produto->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }
        unset($validated['image']);

        $produto->update($validated);
        $produto->clinics()->sync($clinicIds);

        return redirect()->route('comercial.produtos.show', $produto)
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $produto): RedirectResponse
    {
        if ($produto->image_path) {
            Storage::disk('public')->delete($produto->image_path);
        }
        $produto->delete();
        return redirect()->route('comercial.produtos.index')
            ->with('success', 'Produto excluído com sucesso.');
    }
}
