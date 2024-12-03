<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNonExistentException;
use Illuminate\Http\Request;

class ModelNotFoundException extends ModelNonExistentException {
    public function render(Request $req) {
		return redirect()
			->back()
			->withInput($req->except('_token'))
			->with('flash_error', "The item either does not exists or is already deleted")
			->with('has_icon', 'true');
	}
}
