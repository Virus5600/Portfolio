<!DOCTYPE html>
<html lang="en" class="scroll-smooth custom-scrollbar apply-to-all" data-tw-theme="none">
	@include("templates.head", ["title" => $title ?? ""])

	<body class="h-screen min-h-screen font-nasalization">

		@include("templates.noscript")

		<div class="container-fluid flex flex-col h-full">
			@include("templates.navbar")

			@yield("content")
		</div>

		@vite(["resources/js/app.js"])
		@stack("scripts")
	</body>

</html>
