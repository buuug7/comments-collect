@extends('layouts.app')

@section('content')
	<div class="container">
		{{ $errors }}
		<form action="/2" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="name">name</label>
				<input type="text"
					   class="form-control" name="name" id="name">
			</div>

			<div class="form-group">
				<label for="avatar">avatar</label>
				<input type="file" class="form-control-file" name="avatar" id="avatar" placeholder="avatar" aria-describedby="fileHelpId">
			</div>
			<div class="form-group">
				<label for="ip">IP</label>
				<input type="ip" class="form-control" name="ip" id="ip">
			</div>


			<div class="form-group form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="terms" id="terms">
					I agree with <a href="#">Terms</a>
				</label>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
@stop