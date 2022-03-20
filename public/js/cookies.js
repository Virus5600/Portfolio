const cookies = {
	set: function(cookie_name, cookie_val, minutes = 0, callback = null, view = null) {
		$.post('/cookie/set', {
			_token: $('meta[name=_token]').attr('content'),
			cookie_name: cookie_name,
			cookie_val: cookie_val,
			min: minutes,
			view: view
		}).done((data) => {
			if (callback !== null)
				callback(data);
		});
	},
	get: function(cookie_name, callback = null, view = null) {
		$.post('cookie/get',  {
			_token: $('meta[name=_token]').attr('content'),
			cookie_name: cookie_name,
			view: view
		}).done((data) => {
			if (callback !== null)
				callback(data);
		});
	},
	delete: function(cookie_name, callback = null) {
		$.post('cookie/delete',  {
			_token: $('meta[name=_token]').attr('content'),
			cookie_name: cookie_name,
		}).done((data) => {
			if (callback !== null)
				callback(data);
		});
	}
}