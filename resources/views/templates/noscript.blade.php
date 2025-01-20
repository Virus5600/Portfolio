{{-- Removes the code that shows up when script is disabled/not allowed/blocked --}}
<script type="text/javascript" id="for-js-disabled-js" nonce="{{ csp_nonce() }}">
	document.head.insertAdjacentHTML(
		"beforeend",
		`<style type="text/css" id="for-js-disabled" nonce="{{ csp_nonce() }}"> #js-disabled { display: none; } </style>`
	);

	document.addEventListener("DOMContentLoaded", () => {
		document.getElementById("js-disabled").remove();
		document.getElementById("for-js-disabled").remove();
		document.getElementById("for-js-disabled-js").remove();
	});
</script>

<div style="position: absolute; height: 100vh; width: 100vw; background-color: #ccc" id="js-disabled">
	<style type="text/css" nonce="{{ csp_nonce() }}">
		.js-only {
			display: none !important;
		}
	</style>

	<div class="flex flex-row h-full justify-center items-center">
		<div class="flex flex-col my-auto p-4">
			<div class="card my-auto">
				<h4 class="card-header card-title text-center">JavaScript is Disabled</h4>

				<div class="card-body">
					<p class="card-text">This website required <b>JavaScript</b> to run. Please allow/enable JavaScript and refresh the page.</p>
					<p class="card-text">If the JavaScript is enabled or allowed, please check your firewall as they might be the one disabling JavaScript.</p>
				</div>
			</div>
		</div>
	</div>
</div>
