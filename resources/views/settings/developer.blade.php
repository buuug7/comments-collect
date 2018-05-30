@extends('layouts.app')
@section('content')

	<div class="container">
		<div class="headline">
			<h3 class="title">Developer</h3>
		</div>
		<div class="row">
			<div class="col-md-8">
				<passport-clients class="mb-4"></passport-clients>
				<passport-authorized-clients class="mb-4"></passport-authorized-clients>
				<passport-personal-access-tokens class="mb-4"></passport-personal-access-tokens>
			</div>
		</div>
	</div>

@endsection