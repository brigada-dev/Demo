<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Smalot\PdfParser\Parser;
use App\Services\PdfService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PdfService::class, function ($app) {
            return new PdfService(new Parser());
        });
    }

    public function boot()
    {
        //
    }
}