<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The controller for the website's uncategorized pages. This includes the following:
 * - The main page `index` (`/`)
 */
class PageController extends Controller
{
	/**
	 * Shows the website's main page. This is also the landing page and the default page
	 * when the user visits the website.
	 *
	 * @param Request $req The request object
	 *
	 * @return View The view to be displayed
	 */
    public function index(): View
	{
		return view('index');
	}
}
