@extends('layouts.app')

@section('content')
	<div class="container">

		<nav>
			<ol class="breadcrumb rounded-0 bg-white">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				<li class="breadcrumb-item"><a href="#">Help</a></li>
				<li class="breadcrumb-item active">Contribute guide</li>
			</ol>
		</nav>

		<div class="bg-white p-4">

			@md(docs,help/contribute-guide.md)
		</div>
	</div>
@endsection
