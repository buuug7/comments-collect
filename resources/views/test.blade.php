@extends('layouts.app')

@section('content')
	<div class="container">
		<form action="/test" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="name">name</label>
				<input type="text"
					   class="form-control" name="name" id="name">
			</div>
			<div class="form-group">
				<label for="favorites">Favorites</label>
				<select class="form-control" name="favorites" id="favorites">
					<option value="fav1">fav1</option>
					<option value="fav2">fav2</option>
					<option value="fav3">fav3</option>
				</select>
			</div>
			<div class="form-group">
				<label for="avatar">avatar</label>
				<input type="file" class="form-control-file" name="avatar" id="avatar" placeholder="sfsdf" aria-describedby="fileHelpId">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
@stop