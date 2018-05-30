@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<user-widget-component email="{{ $email }}"></user-widget-component>
			</div>
			<div class="col-md-8">
				TODO
			</div>
		</div>
	</div>
@endsection