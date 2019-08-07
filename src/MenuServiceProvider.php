<?php

namespace Tiketux\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');        
        $this->publishes([
            __DIR__.'/components' => resource_path('js/components/menu'),            
        ],"Component_Menu");
    }
}
