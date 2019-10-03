<?php declare(strict_types=1);

namespace Argon\Form;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

use Argon\Form\Command\ArgonCrud;

/**
 * Argon Form Service Provider
 */
class ServiceProvider extends BaseServiceProvider
{
	
	public function register() {
		
	}


	public function boot() {
		View::addNamespace('ArgonForm', realpath(__DIR__.'/../templates'));

		// Diferente das directivas @stack e @push as directivas abaixo armazenam apenas uma vez
		// por arquivo um determinado stilo ou script, isso é importante, pois não gostaríamos de
		// incluir um script mais de uma vez em alguns casos, mesmo que um determinado campo de form
		// seja utilizado mais de uma vez
		Blade::directive('style', function() {
			return "<?php ob_start(); ?>";
		});
		Blade::directive('endstyle', function() {
			return "<?php Form::\$styles[__FILE__] = ob_get_clean(); ?>";
		});

		Blade::directive('script', function() {
			return "<?php ob_start(); ?>";
		});
		Blade::directive('endscript', function() {
			return "<?php Form::\$scripts[__FILE__] = ob_get_clean(); ?>";
		});

		$this->publishes([
			__DIR__.'/../assets' => public_path('assets'),
			__DIR__.'/../lang/pt_BR' => resource_path('lang/pt_BR')
		]);

	    if ($this->app->runningInConsole()) {
	        $this->commands([
	            ArgonCrud::class,
	        ]);
    	}

	}
}