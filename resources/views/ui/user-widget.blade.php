@extends('layouts.app')

@section('content')

	<div class="container">
		<h2 class="mb-5">User widget</h2>
		<div class="row">
			<div class="col-md-4">
				<div class="user-widget bg-white">
					<div class="user-widget__top bg-primary position-relative"
						style="height: 9rem;">
						<div style="bottom: -50px;left: 50%;transform:translate(-50%,0)"
							 class="user-widget__img position-absolute">
							<img class="rounded-circle"
								 src="/images/default-avatar.png"
								 style="width: 100px;height:100px;border:3px solid #fff;">
						</div>
					</div>
					<div class="text-center px-3 pt-4 mt-5">
						<h3 class="mb-3">Buuug7.Twice</h3>
						<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos!</p>
						<a href="#" class="btn btn-outline-primary btn-sm">Follow</a>
					</div>
					<div class="user-widget__down px-3 py-4 d-flex flex-row justify-content-around">
						<div class="d-flex flex-column align-items-center">
							<a href="#" class="small">378</a>
							<span>Posts</span>
						</div>
						<div class="d-flex flex-column align-items-center">
							<a href="#" class="small">1928</a>
							<span>Comments</span>
						</div>
						<div class="d-flex flex-column align-items-center">
							<a href="#" class="small">86</a>
							<span>Flowers</span>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection