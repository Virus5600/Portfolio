@props(['cardClass' => '', 'bodyClass' => ''])

<div class="card {{ $cardClass }}">
	{{ $header ?? '' }}

	<div class="card-body {{ $bodyClass }}">
		{{ $slot }}
	</div>

	{{ $footer ?? '' }}
</div>
