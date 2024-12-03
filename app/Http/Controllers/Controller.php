<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator as Validated;

use Image;

/**
 * This is the base controller which all other controllers extends and derives from.
 *
 * As this was the base controller, it contains some common methods and properties that
 * all other controllers will inherit.
 */
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

	/**
	 * `ADMIN_QUERY_PARAMS` is an array containing the query parameters that are used in the admin panel. These
	 * are usually the parameters that are used to filter, sort, and paginate the data in the admin panel.
	 *
	 * Current parameters are:
	 * - `search`:		The search query to filter the data.
	 * - `sort`:		The column to sort the data by.
	 * - `direction`:	The direction to sort the data by.
	 * - `page`:		The page number to paginate the data by.
	 */
	const ADMIN_QUERY_PARAMS = ["search", "sort", "direction", "page"];
	/**
	 * `EXCEPT` is an array containing the query parameters that should be excluded from the query parameters.
	 * Usually, these are the parameters that are used in the admin panel for filtering, sorting, and paginating
	 * the data.
	 *
	 * Furthermore, this contains some common parameters that are reserved for the request and security that shouldn't
	 * be returned, shown, or used.
	 *
	 * Current parameters are:
	 * - `_token`:	The CSRF token.
	 * - `_method`:	The HTTP method.
	 * - `bearer`:	The bearer token. Usually the Sanctum token.
	 * - `search`:	The search query to filter the data.
	 * - `sort`:	The column to sort the data by.
	 * - `direction`:	The direction to sort the data by.
	 * - `page`:	The page number to paginate the data by.
	 */
	const EXCEPT = ["_token", "_method", "bearer", "search", "sort", "direction", "page"];

	/**
	 * Format the errors from the validator into a format that allows
	 * XHR requests to easily parse the errors.
	 *
	 * @param Validated $validator
	 * @return array
	 */
	protected function formatErrors(Validated $validator): array
    {
        $errors = $validator->errors()->getMessages();
        $obj = $validator->failed();
        $result = [];
        foreach($obj as $input => $rules){
            $i = 0;
            foreach($rules as $rule => $ruleInfo){
                $rule = $input.'['.strtolower($rule).']';
                $result[$rule] = $errors[$input][$i];
                $i++;
            }
        }
        return $result;
    }

	/**
	 * Include the parameters from the request that are in the list of
	 * parameter names. This is useful for including only the parameters
	 * that are needed for the request.
	 *
	 * If the parameter doesn't exist, by default, it will return an empty
	 * string. If you want to set it to `null` instead, you can set the
	 * `$handleNonExistence` parameter to `false`.
	 *
	 * @param array $paramNames The list of parameter names to include.
	 * @param bool $handleNonExistence Whether to handle the non-existence of the parameter.
	 *
	 * @return array
	 */
	protected function includeParams(array $paramNames, bool $handleNonExistence = true): array
	{
		$params = [];
		foreach ($paramNames as $paramName)
			$params[$paramName] = request()->{$paramName} ?? ($handleNonExistence ? "" : null);

		return $params;
	}

	/**
	 * Provides the redirection after a delete action has been performed.
	 *
	 * @param string $fallback The fallback route to redirect to if the previous route is not viable.
	 * @param string $showRouteName The name of the **`show`** route of the said feature.
	 * @param string $showRouteParams The parameters of the **`show`** route. (Optional)
	 *
	 * @return \Illuminate\Http\RedirectResponse The redirection response.
	 */
	protected function redirectAfterDelete(string $fallback, string $showRouteName, array $showRouteParams = []): \Illuminate\Http\RedirectResponse
	{
		$referrer = request()->header('referer');

		return $redirect = $referrer && $referrer == route($showRouteName, $showRouteParams) ?
			redirect()->route($fallback) : redirect()->back();
	}

	/**
	 * Converts any image type into a WEBP image format. This is useful for converting
	 * images into a more optimized format for the web.
	 *
	 * The converted image will be saved to the specified path with the specified filename. The
	 * image's quality can also be specified with the `$quality` parameter being set between 0 and 100.
	 * Setting the `$quality` less than 0 will set it to 0 and setting it more than 100 will set it to 100.
	 *
	 * @param string $filename The filename of the image.
	 * @param UploadedFile $image The image file.
	 * @param string $saveToPath The path to save the converted image to.
	 * @param int $quality The quality of the converted image. (Default: 75)
	 *
	 * @return \Intervention\Image\Image The converted image.
	 */
	protected function convertToWEBP(string $filename, UploadedFile $image, string $saveToPath, $quality = 75): \Intervention\Image\Image
	{
		// Handles the quality value. Max is 100.
		$quality = $quality > 100 ? 100 : ($quality < 0 ? 0 : $quality);

		$path = public_path("{$saveToPath}/{$filename}");

		$image = Image::read($image);
		$image->toWebp($quality)
			->save($path);

		return $image;
	}
}
