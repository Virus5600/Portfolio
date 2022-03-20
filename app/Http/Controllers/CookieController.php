<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cookie;
use Exception;
use Log;

class CookieController extends Controller
{
	protected function setCookie(Request $req) {
		if (!$req->has('cookie_name'))
			throw Exception('Cookie name not provided. Please provide a name to identify the cookie.');
		if (!$req->has('cookie_val'))
			throw Exception('Cookie value not provided. Please provide a value to identify the value of the cookie.');

		$minutes = ($req->has('min') ? ($req->min <= 0 ? 0 : $req->min) : 1);
		
		if ($minutes <= 0)
			$cookie = Cookie::forever($req->cookie_name, $req->cookie_val);
		else
			$cookie = Cookie::make($req->cookie_name, $req->cookie_val, $minutes);

		if ($req->has('view') && $req->view != null)
			return response()
				->view($req->view)
				->json([$req->cookie_name => $req->cookie_val], 200)
				->withCookie($cookie);

		return response()
			->json([$req->cookie_name => $req->cookie_val], 200)
			->withCookie($cookie);
	}

	protected function getCookie(Request $req) {
		if (!$req->has('cookie_name'))
			throw Exception('Cookie name not provided. Please provide a name to identify which cookie to fetch.');

		if (!Cookie::has($req->name))
			$cookie = 'null';
		else
			$cookie = Cookie::get($req->cookie_name);

		if ($req->has('view') && $req->view != null) {
			return response()
				->view($req->view)
				->json([
					'name' => $req->name,
					'value' => $cookie
				]);
		}

		return response()->json([
			'name' => $req->cookie_name,
			'value' => $cookie
		]);
	}

	protected function deleteCookie(Request $req) {
		if (!$req->has('cookie_name'))
			throw Exception('Cookie name not provided. Please provide a name to identify which cookie to fetch.');

		$cookie = Cookie::forget($req->cookie_name);

		return response()
			->json(['success' => !Cookie::has($req->cookie_name) ? '1' : '0'])
			->withCookie($cookie);
	}

	// STATIC CALL
	public static function set($cookie_name, $cookie_val, $minutes = 1) {
		if (!isset($cookie_name))
			throw Exception('Cookie name not provided. Please provide a name to identify the cookie.');
		if (!isset($cookie_val))
			throw Exception('Cookie value not provided. Please provide a value to identify the value of the cookie.');
		
		if ($minutes <= 0)
			$cookie = Cookie::forever($req->cookie_name, $req->cookie_val);
		else
			$cookie = Cookie::make($req->cookie_name, $req->cookie_val, $minutes);

		return response()
			->json([$req->cookie_name => $cookie_val], 200)
			->withCookie($cookie);
	}

	public static function get($cookie_name) {
		if (!isset($cookie_name))
			throw Exception('Cookie name not provided. Please provide a name to identify which cookie to fetch.');

		if (!isset($cookie_name))
			$cookie = 'null';
		else
			$cookie = Cookie::get($cookie_name);

		return response()->json([
			'name' => $cookie_name,
			'value' => $cookie
		]);
	}

	public static function delete($cookie_name) {
		if (!$req->has('cookie_name'))
			throw Exception('Cookie name not provided. Please provide a name to identify which cookie to fetch.');

		Cookie::forget($cookie_name);

		return response()
			->json(['success' => !Cookie::has($cookie_name) ? '1' : '0'])
			->withCookie($cookie);
	}
}