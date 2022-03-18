const cookies = {
	set: function(cookie_name, cookie_val, minutes = 0, callback = null) {
		$.post('/cookie/set', {
			_token: $('meta[name=_token]').attr('content'),
			cookie_name: cookie_name,
			cookie_val: cookie_val,
			min: minutes
		}).done((data) => {
			if (callback !== null)
				callback(data);
		});
	},
	get: function(cookie_name, callback = null) {
		$.post('cookie/get',  {
			_token: $('meta[name=_token]').attr('content'),
			cookie_name: cookie_name,
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