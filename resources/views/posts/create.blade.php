@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Create post</h2>
		<div>
			<form action="{{ url('posts') }}" method="post">
				@csrf
				<div class="form-group">
					<label for="reference">reference</label>
					<input type="text" name="reference" id="reference" class="form-control">
				</div>
				<div class="form-group">
					<label for="contents">contents</label>
					<textarea name="contents" id="body" class="form-control"></textarea>
				</div>
				<button class="btn btn-primary" type="submit">submit</button>
			</form>
		</div>
	</div>
@stop