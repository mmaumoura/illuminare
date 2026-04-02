<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClinicScopeController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $clinicId = $request->input('clinic_id');

        if ($clinicId) {
            $exists = Clinic::where('id', $clinicId)->exists();
            abort_if(!$exists, 404);
            session(['active_clinic_id' => (int) $clinicId]);
        } else {
            session()->forget('active_clinic_id');
        }

        return redirect()->back();
    }
}
