@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="mb-4">tag detail</h2>
		<div class="tag__detail bg-white p-4">
			<p>{{ $tag->name }}</p>
			<p>{{ $tag->slug }}</p>
			<p>
				<small>{{ $tag->created_at }}</small>
			</p>
			<div class="mb-0">
				@can('delete',$tag)
					<form action="{{ '/tags/'.$tag->id }}"
						  method="post"
						  style="display: inline-block">
						@csrf
						@method('delete')
						<button type="submit" class="btn btn-danger">delete</button>
					</form>
				@endcan
			</div>
		</div>
	</div>
@endsection