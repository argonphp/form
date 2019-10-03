<?php declare(strict_types=1);

namespace Argon\Form;
use Illuminate\Support\Facades\View;

/**
 * Argon Form Helper
 */
class Helper
{
	public static $styles = [];
	public static $scripts = [];

	protected $properties = [];
	protected $viewName = null;

	public static function __styles() {
		// foreach (self::$styles as $style) $style();
		foreach (self::$styles as $style) echo $style;
	}

	public static function __scripts() {
		// foreach (self::$scripts as $script) $script();
		foreach (self::$scripts as $script) echo $script;
	}
	private function __construct(string $viewName, $inputName) {
		$this->viewName = $viewName;
		$this->properties['name'] = $inputName;
		$this->properties['id'] = 'id_'.uniqid();
	}

	public function __call(string $property, array $value) {
		if (empty($value)) {
			$value[0] = true;
		}
		$this->properties[$property] = $value[0];
		return $this;
	}

	public static function __callStatic($method, $arguments) {
		return new self($method, $arguments[0]);
	}

	public function __toString() {
		$view = View::make("ArgonForm::{$this->viewName}", $this->properties);
		return $view->render();
	}

	public static function _route($route, $id) {
	  $r = \Route::getRoutes()->getByName("$route");
	  $parameters = $r->parameterNames();
	  $routeParameter = $parameters[0];
	  return route("$route", [$routeParameter=>$id]);
	}


}