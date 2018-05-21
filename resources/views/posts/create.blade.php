@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Create post</h2>
		<div>
			<form action="{{ url('posts') }}" method="post">
				@csrf
				<div class="form-group">
					<label for="reference">reference</label>
					<input type="text" name="reference" id="reference" class="form-control" value="{{ old('reference') }}">
				</div>
				<div class="form-group">
					<label for="contents">contents</label>
					<textarea name="contents" id="contents" class="form-control">{{ old('contents') }}</textarea>
				</div>

				<div class="form-group">
					@foreach ($tags as $tag)
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="tags[]" id="tags" value="{{ $tag->id }}">
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
	</div>
@endsection