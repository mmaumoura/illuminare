<?php

namespace App\Providers;

use App\Models\Clinic;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $canSwitch = $user->isAdministrador() || $user->isGestor();

                $view->with('navClinics', $canSwitch ? Clinic::where('active', true)->orderBy('name')->get() : collect());
                $view->with('activeClinicId', $canSwitch ? session('active_clinic_id') : $user->clinic_id);
                $view->with('canSwitchClinic', $canSwitch);
            }
        });
    }
}
