<?php

if (!function_exists("extractQueryParams")) {
	/**
	 * Extracts all the query parameters from the given URL, which will then be
	 * returned as an array. If no query parameters are found, an empty array
	 * will be returned.
	 *
	 * @param string $url The URL to extract the query parameters from.
	 *
	 * @return array
	 */
	function extractQueryParams(string $url): array
	{
		$parsedURL = parse_url($url);

		if (!array_key_exists('query', $parsedURL))
			return [];

		parse_str($parsedURL['query'], $output);

		return $output;
	}
}

if (!function_exists("relRoute")) {
	/**
	 * Generates a relative URL for the given route, with the given parameters.
	 * If the route is not found, an empty string will be returned.
	 *
	 * @param string $route  The route to generate the URL for.
	 * @param array  $params The parameters to pass to the route.
	 *
	 * @return string
	 */
	function relRoute(string $route, array $params = []): string
	{
		return route($route, $params, true);
	}
}
