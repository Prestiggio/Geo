<?php

namespace Ry\Geo\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Ry\Geo\Models\Country;
use Ry\Geo\Models\Ville;
use Ry\Geo\Console\Commands\Geocoder;

class RyServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	/*
    	$this->publishes([    			
    			__DIR__.'/../config/rygeo.php' => config_path('rygeo.php')
    	], "config");  
    	$this->mergeConfigFrom(
	        	__DIR__.'/../config/rygeo.php', 'rygeo'
	    );
    	$this->publishes([
    			__DIR__.'/../assets' => public_path('vendor/rygeo'),
    	], "public");    	
    	*/
    	//ressources
    	$this->loadViewsFrom(__DIR__.'/../ressources/views', 'rygeo');
    	$this->loadTranslationsFrom(__DIR__.'/../ressources/lang', 'rygeo');
    	/*
    	$this->publishes([
    			__DIR__.'/../ressources/views' => resource_path('views/vendor/rygeo'),
    			__DIR__.'/../ressources/lang' => resource_path('lang/vendor/rygeo'),
    	], "ressources");
    	*/
    	$this->publishes([
    			__DIR__.'/../database/factories/' => database_path('factories'),
	        	__DIR__.'/../database/migrations/' => database_path('migrations')
	    ], 'migrations');
    	$this->map();
    	//$kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
    	//$kernel->pushMiddleware('Ry\Facebook\Http\Middleware\Facebook');
    	
    	app("ryanalytics.slug")->register("country", Country::class);
    	app("ryanalytics.slug")->register("ville", Ville::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->register(\Ry\Analytics\Providers\RyServiceProvider::class);
    	$this->app->register(\Ry\Socin\Providers\RyServiceProvider::class);
    	
    	$this->app->singleton('rygeo.code', function(){
    	    return new Geocoder();
    	});
    	$this->commands(['rygeo.code']);
    }
    public function map()
    {    	
    	if (! $this->app->routesAreCached()) {
    		$this->app['router']->group(['namespace' => 'Ry\Geo\Http\Controllers'], function(){
    			require __DIR__.'/../Http/routes.php';
    		});
    	}
    }
}