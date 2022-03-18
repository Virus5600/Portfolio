<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CookieController as CC;

use Illuminate\Http\Request;

use Cookie;
use Log;

class PageController extends Controller
{
	protected function index(Request $req) {
		$isGame = CC::get('is_game')->getData()->value ? CC::get('is_game')->getData()->value : 'false';
		
		return view('index', [
			'isGame' => $isGame,
		]);
	}
}