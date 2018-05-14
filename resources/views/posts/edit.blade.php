@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Edit post</h2>
		<form action="{{ url('posts/'.$post->id) }}" method="post">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="reference">reference</label>
				<input type="text"
					   name="reference"
					   id="reference"
					   class="form-control"
					   value="{{ $post->reference }}">
			</div>
			<div class="form-group">
				<label for="contents">contents</label>
				<textarea name="contents" id="contents" class="form-control">{{ $post->contents }}</textarea>
			</div>

			<div class="form-group">
				@foreach ($tags as $tag)
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input type="checkbox"
								   class="form-check-input"
								   name="tags[]"
								   id="tags"
								   value="{{ $tag->id }}"
									{{ in_array($tag->id,$post->tags()->pluck('id')->toArray()) ? 'checked':'' }}
							>
							{{ $tag->name }}
						</label>
					</div>
				@endforeach
			</div>

			<p>
				Does not have a proper tags? click <a href="#">me</a> create new one.
			</p>

			<button class="btn btn-primary" type="submit">submit</button>
		</form>
	</div>
@endsection