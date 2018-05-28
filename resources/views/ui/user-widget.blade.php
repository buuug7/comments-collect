@extends('layouts.app')

@section('content')

	<div class="container">
		<h2>User widget</h2>


		<div class="user-widget bg-white p-5 position-relative">
			<div class="user-widget__top">
				<div class="user-widget__img position-absolute">
					<img class="rounded-circle" style="width: 100px;height:100px;" src="{{ Auth::user()->getAvatar() }}" alt="">
				</div>
				<div class="name">{{ Auth::user()->name }}</div>
				<div class="email">{{ Auth::user()->email }}</div>
			</div>
			<div class="user-widget__down p-5 d-flex justify-content-center flex-row">
				<div class="d-flex flex-column">
					<a href="#">222</a>
					<span>Lorem ipsum</span>
				</div>
				<div class="d-flex flex-column">
					<a href="#">222</a>
					<span>Lorem ipsum</span>
				</div>
				<div class="d-flex flex-column">
					<a href="#">222</a>
					<span>Lorem ipsum</span>
				</div>
			</div>
		</div>
	</div>
@endsection