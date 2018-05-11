@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="mb-4">Post detail</h2>
		<ul class="list-unstyled">
			<li class="bg-white p-3 mb-4">
				<p> {{ $post->contents }}</p>
				<p class="text-muted">Reference:{{ $post->reference }}</p>
				<p>
					<small>{{ $post->created_at }}</small>
				</p>
				<p class="mb-0">
				@can('delete',$post)
					<form action="{{ '/posts/'.$post->id }}"
						  method="post"
						  style="display: inline-block">
						@csrf
						@method('delete')
						<button type="submit" class="btn btn-danger">delete</button>
					</form>
					@endcan
				</p>
			</li>
		</ul>
	</div>
@stop