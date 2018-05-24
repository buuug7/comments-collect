<nav class="navbar navbar-expand-md navbar-light bg-white navbar-laravel box-shadow-4">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			{{ config('app.name', 'Laravel') }}
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/post-create">Ranking list</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/contribute') }}">Contribute</a>
				</li>
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
					<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
					<li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
				@else
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>

						<div class="dropdown-menu" aria-labelledby="navbarDropdown">

							<a class="dropdown-item" href="{{ url('/users/my/posts') }}">My Posts</a>

							<a class="dropdown-item" href="{{ url('/users/my/posts/star') }}">Star Posts</a>

							<a class="dropdown-item" href="{{ url('/users/my/comments') }}">My Comments</a>

							<a class="dropdown-item" href="{{ url('/users/my/comments/liked') }}">Liked Comments</a>

							<a class="dropdown-item" href="{{ url('/settings/profile') }}">Profile</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item"
							   href="{{ route('logout') }}"
							   onclick="event.preventDefault();
							   document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>