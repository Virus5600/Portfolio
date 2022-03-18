@extends('layout.user')

@section('content')
<div class="container-fluid">
	<span class="badge badge-primary w-100">
		Is Dark: <span id="is_dark_val">{{ Cookie::get('is_dark') ? Cookie::get('is_dark') : 'null' }}</span>
	</span>

	<div class="d-flex">
		<button class="btn btn-secondary w-50 mx-2" id="update">Click me</button>
		<button class="btn btn-secondary w-50 mx-2" id="remove">Remove</button>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/cookies.js') }}"></script>
<script type="text/javascript">
	function setText(data) {
		let obj = $('#is_dark_val');

		if (typeof data.is_dark !== 'undefined') {
			obj.text(data.is_dark);
			if (JSON.parse(data.is_dark))
				$('head').append(`<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.6.0/dist/darkly/bootstrap.min.css" id="dark_theme">`);
			else
				$('#dark_theme').remove();
		}
		else if (typeof data.success !== 'undefined')
			obj.text(data.success == '0' ? 'null' : 'exists');
	}

	$(document).ready(function() {
		$('#update').click(() => {
			cookies.set('is_dark', !JSON.parse($('#is_dark_val').text()), 0, setText);
		});

		$('#remove').click(() => {
			cookies.delete('is_dark', setText);
		});
	});
</script>
@endsection