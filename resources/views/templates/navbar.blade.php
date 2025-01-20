<nav class="navbar sticky top-0 bg-transparent shadow-none">
	<div class="navbar-contents">
		<a href="{{ relRoute("home") }}" class="navbar-brand">
			<img src="{{ $webLogo }}" class="h-8" alt="Flowbite Logo" />
			{{ $webName }}
		</a>

		<button data-drawer-target="mainNavbar" data-drawer-show="mainNavbar" type="button" class="navbar-toggler" aria-controls="mainNavbar" id="mainNavbarToggler" data-drawer-placement="right" data-drawer-backdrop-classes="bg-[var(--bg-body)]">
			<span class="sr-only">Open main menu</span>

			<span class="navbar-toggler-icon custom-icon">
				<i class="fas fa-bars transition-transform"></i>
			</span>
		</button>

		<div class="navbar-drawer right-drawer duration-500!important" id="mainNavbar" tabindex="-1" aria-labelledby="mainNavbarToggler">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="nav-link" aria-current="page">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">About</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Services</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Pricing</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Contact</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
