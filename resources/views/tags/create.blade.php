@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Create tag</h2>
		<div>
			<form action="{{ url('tags') }}" method="post">
				@csrf
				<div class="form-group">
					<label for="name">name</label>
					<input type="text" name="name"
						   id="name"
						   class="form-control"
						   value="{{ old('name') }}">
				</div>

				<button class="btn btn-primary" type="submit">submit</button>
			</form>
		</div>
	</div>
@stop