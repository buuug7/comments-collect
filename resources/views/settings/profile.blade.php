@extends('layouts.app')
@section('content')

	<div class="container">
		<div class="p-4">
			<div class="headline">
				<h3 class="title">User profiles</h3>
			</div>

			<div class="headline-v2 mt-5">
				<h4 class="title">Avatar</h4>
			</div>

			<avatar-upload-cropper-component
					default-avatar={{ Auth::user()->getAvatar() }}
							:allowed-mime-types='["image/jpg","image/jpeg","image/png"]'
					:cropped-width="200"
					:cropped-height="200"
			></avatar-upload-cropper-component>

			<div class="headline-v2 mt-5">
				<h4 class="title">Profile</h4>
			</div>
			<user-profile-component></user-profile-component>
		</div>
	</div>

@endsection