<?php

namespace Niklasravnsborg\LaravelPdf;

use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('mpdf.wrapper', function ($app) {
            return new LaravelPdfWrapper();
        });

        $this->app->alias('mpdf.wrapper', 'MPDF');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/pdf.php' => config_path('pdf.php'),
        ]);
    }
}
