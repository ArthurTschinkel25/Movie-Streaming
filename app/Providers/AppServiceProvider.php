<?php

namespace App\Providers;
use App\Http\Livewire\MovieFormComponent;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire; // 1. Importe a classe Livewire

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
    public function boot()
    {
        Livewire::component('movie-form-component', MovieFormComponent::class);
    }
}
