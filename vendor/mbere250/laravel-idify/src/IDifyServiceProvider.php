<?php

namespace Mbere250\IDify;

use Illuminate\Support\ServiceProvider;

class IDifyServiceProvider extends ServiceProvider
{
  

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IDify::class, function(){
            return new IDify;
        }); 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
    }
}
