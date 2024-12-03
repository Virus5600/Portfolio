<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-tw-theme="none">
	@include("templates.head", ["title" => $title ?? ""])

	<body class="h-screen min-h-screen">
		<div class="container-fluid flex flex-col h-full">
			@yield("content")
		</div>

		@vite(["resources/js/app.js"])
		@stack("scripts")
	</body>
</html>
