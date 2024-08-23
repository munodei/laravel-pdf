<?php

namespace Niklasravnsborg\LaravelPdf;

use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mpdf.wrapper', function ($app) {
            return new LaravelPdfWrapper();
        });

        $this->app->alias('mpdf.wrapper', 'MPDF');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/config/pdf.php' => config_path('pdf.php'),
        ]);

        // Laravel 11: Automatically register the service provider
        ServiceProvider::addProviderToBootstrapFile(self::class);
    }
}
