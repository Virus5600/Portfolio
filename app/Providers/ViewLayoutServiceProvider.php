<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\View;

use App\Models\Settings;
use App\Models\User;

use Debugbar;
use Exception;
use Log;
use Schema;

class ViewLayoutServiceProvider extends ServiceProvider
{
	/**
	 * Holds the lists of website settings value and what method will be used to call upon them.
	 *
	 * The key will define the name of the variable and the database identifier while the value will
	 * define the method to be used. If the value is an array, then the first value will be the method
	 * to be called and the rest will be the chain method to be called. Please take note that the method
	 * ***should be a static method***, and if the value is an ***array***, then the **first value should be a static
	 * method while the rest should be a non-static chainable method**.
	 *
	 * Furthermore, the methods that will be called should return a value and should be from the Settings model.
	 * The methods should also not take parameters or at least, has a set of default parameters as the code
	 * will not be able to pass any parameters to the method.
	 *
	 * Example:
	 * ```
	 * "web-name" => "getValue",
	 * ```
	 *
	 * The code will call the `getValue` method from the Settings model and pass the `web-name` as the parameter.
	 * If converted into an actual code, it will look like this:
	 * ```
	 * $webName = Settings::getValue('web-name');
	 * ```
	 *
	 * Example:
	 * ```
	 * "web-logo" => ["getInstance", "getImage"],
	 * ```
	 *
	 * The code will call the `getInstance` method from the Settings model and pass the `web-logo` as the parameter.
	 * Then it will call the `getImage` method from the instance that was returned by the `getInstance` method.
	 * If converted into an actual code, it will look like this:
	 *
	 * ```
	 * $webLogo = Settings::getInstance('web-logo')->getImage();
	 * ```
	 *
	 * @var array
	 */
	private const TO_ADD = [
		"web-name" => "getValue",
		"web-desc" => "getValue",
		"web-logo" => ["getInstance", "getImage"],
	];

	/**
	 * Register services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		// Sets the nonce for the CSP when in dev/local environment.
		if (in_array(strtolower(config('app.env')), AppServiceProvider::DEV_ENV)) {
			Debugbar::getJavascriptRenderer()->setCspNonce(csp_nonce());
		}

		try {
			// Website information.
			if (Schema::hasTable("settings") && Settings::count() > 0)
				$this->attachWebsiteInfo();

			view()->composer(
				'layouts.admin',
				function($view) {
					$user = auth()->user();

					if ($user)
						$this->attachUserPermissions($view, $user);
				}
			);
		} catch (Exception $e) {
			Log::error($e);
		}
	}

	/**
	 * Attaches the website information to all the view.
	 */
	private function attachWebsiteInfo() {
		// Fetch the constant TO_ADD array and iterate through it.
		foreach(self::TO_ADD as $key => $value) {
			// Check if the value is an array.
			if (is_array($value)) {
				// If it is, then get the first value and call the method.
				$method = $value[0];
				$val = Settings::$method($key);

				// Then iterate through the rest of the chain method.
				foreach($value as $i => $v) {
					// Skip the first value since it was already been called earlier.
					if ($i == 0) continue;
					$val = $val->$v();
				}
			}
			// If not, then call the method directly.
			else {
				$val = Settings::$value($key);
			}

			// Then add the value to the views.
			view()->share(Str::camel($key), $val);
		}

		// $webName = Settings::getValue('web-name');
		// $webDesc = Settings::getValue('web-desc');
		// $webLogo = Settings::getInstance('web-logo')->getImage();
	}

	private function attachUserPermissions(View $view, User $user) {
		$perms = [];
		foreach ($user->permissions() as $p)
			array_push($perms, $p->slug);

		$view->with(
			"userPerms",
			$perms
		);
	}
}
