@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="headline">
			<h3 class="title">My star posts ({{ Auth::user()->starPosts()->count() }})</h3>
		</div>
		<div class="row">
			<div class="col-md-8">
				<posts-component
						request-url="/users/posts/star"
						request-method="post">
				</posts-component>
			</div>
		</div>
	</div>
@endsection