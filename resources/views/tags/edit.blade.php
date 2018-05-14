@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Edit tag</h2>
		<form action="{{ url('tags/'.$tag->id) }}" method="post">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="name">name</label>
				<input type="text"
					   name="name"
					   id="name"
					   class="form-control"
					   value="{{ $tag->name }}">
			</div>
			<button class="btn btn-primary" type="submit">submit</button>
		</form>
	</div>
@endsection