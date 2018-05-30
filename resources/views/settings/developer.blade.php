@extends('layouts.app')
@section('content')

	<div class="container">
		<div class=" p-4">
			<div class="headline">
				<h3 class="title">Developer</h3>
			</div>

			<passport-clients></passport-clients>
			<passport-authorized-clients></passport-authorized-clients>
			<passport-personal-access-tokens></passport-personal-access-tokens>
		</div>
	</div>

@endsection