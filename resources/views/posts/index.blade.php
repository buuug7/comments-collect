@extends('layouts.app')

@section('content')

	<div class="container">
		<h2 class="mb-4">Posts</h2>
		<div class="my-4">
			<a href="/posts/create" class="btn btn-success">Add</a>
		</div>
		<ul class="list-unstyled">
			@foreach ($posts as $post)
				<li class="bg-white p-3 mb-4">
					<p>Created by <a href="#">{{ $post->user->name }}</a></p>
					<p> {{ $post->contents }}</p>
					<p class="text-muted">Reference:{{ $post->reference }}</p>
					<p>Laste updated:
						<small>{{ $post->updated_at }}</small>
					</p>
					<p class="mb-0">
						<a href="{{ '/posts/'.$post->id }}" class="btn btn-primary">detail</a>
					</p>
				</li>
			@endforeach
		</ul>
		{{ $posts->links() }}
	</div>
@endsection