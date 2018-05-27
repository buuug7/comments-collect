@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="headline">
			<h3 class="title">Notification ({{ Auth::user()->unreadNotifications()->count() }})</h3>
		</div>
		<div class="row">
			<div class="col-md-8">
				<user-notifications-component
						request-url="{{ url('/users/notifications') }}"
						request-method="post">
				</user-notifications-component>
			</div>
		</div>
	</div>
@endsection