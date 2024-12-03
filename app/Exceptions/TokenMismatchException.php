<?php

namespace App\Exceptions;

use Illuminate\Session\TokenMismatchException as WrongTokenException;
use Illuminate\Http\Request;

class TokenMismatchException extends WrongTokenException {
	public function render(Request $req) {
		return redirect()
			->back()
			->withInput($req->except('_token'))
			->with('flash_error', "The item either does not exists or is already deleted")
			->with('has_icon', 'true');
	}
}
