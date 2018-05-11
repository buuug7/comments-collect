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
			<button class="btn btn-primary" type="submit">submit</button>
		</form>
	</div>
@stop