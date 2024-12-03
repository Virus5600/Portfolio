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
