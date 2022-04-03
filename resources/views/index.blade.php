@extends('layouts.user')

@section('content')
@include('templates.navbar')

<div class="container-fluid">
	@for($i = 1; $i < rand(25,100); $i++)
	<br>
	<p class="text-dark">TEST {{ $i }}</p>
	<br>
	@endfor
</div>
@endsection