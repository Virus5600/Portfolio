{{-- Navbar --}}
<nav class="navbar navbar-expand-md navbar-dark bg-semi-dark sticky-top py-1">
	{{-- BRANDING --}}
	<a href="{{ route('home') }}" class="navbar-brand font-nasalization-rg">
		<img src="{{ asset('uploads/images/settings/favicon.png') }}" id="brand-icon" class="img img-fluid mr-2" alt="Virus5600" draggable="false">Virus5600
	</a>

	{{-- Toggle Button --}}
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa-solid fa-bars"></i>
	</button>

	{{-- Navbar Contents --}}
	<div class="collapse navbar-collapse" id="navbar-content">
		<ul class="navbar-nav w-100 mr-md-auto mx-auto">
			<li>Home</li>
		</ul>
	</div>

	{{-- Setting/Toggles --}}
	<div class="ml-md-auto d-flex flex-row">
		<i class="fa-solid fa-lightbulb cursor-pointer" id="dark_mode_toggle"></i>
	</div>
</nav>