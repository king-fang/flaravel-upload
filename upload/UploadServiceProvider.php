<?php

namespace App\Libs\Upload;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $source =  realpath(__DIR__.'/uploads.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('upload.php')], 'flaravel');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('upload',function($app){
            return new UploadManager($app);
        });
    }

    public function provides()
    {
        return [
            'upload'
        ];
    }
}
