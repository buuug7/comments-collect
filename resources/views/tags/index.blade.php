@extends('layouts.app')

@section('content')

	<div class="container">
		<h2 class="mb-4">Tags</h2>
		<div class="my-4">
			<a href="/tags/create" class="btn btn-success">Add</a>
		</div>
		<ul class="list-unstyled">
			@foreach ($tags as $tag)
				<li class="bg-white p-3 mb-4">
					<p>Created by <a href="#">{{ $tag->user->name }}</a></p>
					<p> {{ $tag->name }}</p>
					<p>Last updated:
						<small>{{ $tag->updated_at }}</small>
					</p>
					<p class="mb-0">
						<a href="{{ '/tags/'.$tag->id }}" class="btn btn-primary">detail</a>
					</p>
				</li>
			@endforeach
		</ul>
		{{ $tags->links() }}
	</div>

@endsection