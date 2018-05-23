@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="headline">
			<h3 class="title">My liked comments</h3>
		</div>
		<div class="row">
			<div class="col-md-8">
				<comments-component
						:post-id="null"
						request-url="/users/comments/liked">
				</comments-component>
			</div>
		</div>
	</div>
@endsection