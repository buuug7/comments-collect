@extends('layouts.app')
@section('content')

	<div class="container">
		<div class="bg-white p-4">
			<h2 class="my-4">User profiles</h2>

			<h4>Avatar</h4>
			<avatar-upload-cropper-component
					default-avatar={{ Auth::user()->getAvatar() }}
							:allowed-mime-types='["image/jpg","image/jpeg","image/png"]'
					:cropped-width="200"
					:cropped-height="200"
			></avatar-upload-cropper-component>

			<h4 class="mt-5">Profile</h4>
			<user-profile-component></user-profile-component>
		</div>
	</div>

@endsection