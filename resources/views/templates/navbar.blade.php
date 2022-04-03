{{-- Navbar --}}
<nav class="navbar navbar-expand-md bg-transparent sticky-top py-1 font-nasalization transition-d2-e-in-out" id="navbar">
	{{-- Toggle Button --}}
	<a href="#navbarContent" class="mr-4 text-dark" data-toggle="collapse" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
		<div class="menu-toggle cursor-pointer" id="hamburger-menu">
			{{-- 1ST ROW --}}
			<span class="bg-dark"></span>
			<span class="bg-dark"></span>
			{{-- 2ND ROW --}}
			<span class="bg-dark"></span>
			<span class="bg-dark"></span>
			{{-- 3RD ROW --}}
			<span class="bg-dark"></span>
			<span class="bg-dark"></span>
		</div>
	</a>

	{{-- BRANDING --}}
	<a href="{{ route('home') }}" class="navbar-brand text-dark">
		<img src="{{ asset('uploads/images/settings/favicon.png') }}" id="brand-icon" class="img img-fluid mr-2" alt="Virus5600" draggable="false">Virus5600
	</a>

	{{-- Setting/Toggles --}}
	<div class="ml-md-auto d-flex flex-row">
		@if (Cookie::get('is_dark') == 'true')
		<i class="fa-solid fa-moon fa-xl cursor-pointer dark-mode-toggle init"></i>
		@else
		<i class="fa-solid fa-sun fa-xl cursor-pointer dark-mode-toggle init"></i>
		@endif
	</div>
</nav>