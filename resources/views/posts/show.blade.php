@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="mb-4">Post detail</h2>
		<div class="post__detail bg-white p-4">
			<p> {{ $post->contents }}</p>
			<p class="text-muted">Reference:{{ $post->reference }}</p>
			@if (count($post->tags))
				<div class="mb-3">
					@foreach ($post->tags as $tag)
						<a href="#" class="badge badge-secondary">{{ $tag->name }}</a>
					@endforeach
				</div>
			@endif

			<p>
				<small>{{ $post->created_at }}</small>
			</p>
			<div class="mb-0">
				@can('delete',$post)
					<form action="{{ '/posts/'.$post->id }}"
						  method="post"
						  style="display: inline-block">
						@csrf
						@method('delete')
						<button type="submit" class="btn btn-danger">delete</button>
					</form>
				@endcan
				@can('update',$post)
					<a href="{{ url('/posts/'.$post->id.'/edit') }}" class="btn btn-success">edit</a>
				@endcan
			</div>
		</div>
	</div>
@endsection