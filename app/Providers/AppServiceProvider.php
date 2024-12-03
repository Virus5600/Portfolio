<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Barryvdh\Debugbar\Facades\Debugbar;

use BadMethodCallException;
use Exception;
use URL;
use Validator;

class AppServiceProvider extends ServiceProvider
{

	/**
	 * A list of custom Faker classes to be implemented.
	 *
	 * @var array
	 */
	private $fakerClasses = [
		//
	];

	/**
	 * A list of custom validation classes to be implemented. Each class must have a `validate` method and a `MESSAGE` constant.
	 *
	 * @var array
	 */
	private $validationClasses = [
		//
	];

	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		if (in_array(strtolower(config('app.env')), ['local', 'testing'])) {
			// New Faker Methods
			$this->implementFakeMethods();

			// Add Debugbar to Alias
			AliasLoader::getInstance()
				->alias('Debugbar', Debugbar::class);
		}
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		// Sets Tailwind CSS as the default pagination styling.
		Paginator::useTailwind();

		// Implement Custom Rules
		$this->implementCustomRules();

		// Use HTTPS when not in testing or local/dev environment (forced).
		$envArr = [
			'local',
			'development',
			'testing'
		];

		if (!in_array(strtolower(config('app.env')), $envArr)) {
			URL::forceHttps();
		}
	}

	/**
	 * Implements custom methods for the Faker library defined in the `$fakerClasses` array.
	 *
	 * @return void
	 */
	private function implementFakeMethods(): void
	{
		// For when using `$this->faker` in factories...
		$this->app->singleton(\Faker\Generator::class, function() {
			$faker = \Faker\Factory::create(config('app.faker_locale', 'en_PH'));

			foreach ($this->fakerClasses as $class) {
				$faker->addProvider(new $class($faker));
			}

			return $faker;
		});
	}

	/**
	 * Implements custom validation rules defined in the $validationClasses array.
	 *
	 * @return void
	 *
	 * @throws BadMethodCallException
	 * @throws Exception
	 */
	private function implementCustomRules(): void
	{

		foreach($this->validationClasses as $class) {
			// If "validate" method isn't defined.
			if (!method_exists($class, 'validate'))
				throw new BadMethodCallException("Method 'validate' does not exist in class '{$class}'");

			// If "MESSAGE" constant isn't defined.
			if (!defined($class . '::MESSAGE'))
				throw new Exception("Constant 'MESSAGE' does not exist in class '{$class}'");

			$rule = Str::snake(class_basename($class), '-');
			$method = $class . '@validate';
			$msg = $class::MESSAGE;

			Validator::extend(
				$rule,
				$method,
				$msg
			);
		}
	}
}
