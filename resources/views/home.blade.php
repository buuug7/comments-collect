@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <posts-component></posts-component>
        </div>
        <div class="col-md-4">
            <div class="card text-center rounded-0 mb-4">

                <div class="card-body">
                    <h5 class="card-title">Awesome Comments Collection</h5>
                    <p class="card-text">
                        Make your favorite comments persist forever.
                    </p>
                    <a href="/post-create" class="btn btn-primary">Contribute</a>
                </div>
            </div>

            <div class="card text-center rounded-0 mb-4">

                <div class="card-body">
                    <h5 class="card-title">Before contribute</h5>
                    <p class="card-text">
                        Need to know some principles of contribution.
                    </p>
                    <a href="/help/contribute-guide" class="btn btn-primary">View detail</a>
                </div>
            </div>

            <div class="card text-center rounded-0 mb-4">

                <div class="card-body">
                    <h5 class="card-title">Acknowledgement</h5>
                    <p class="card-text">
                    <ul class="list-unstyled">
                        <li><a href="https://github.com/laravel/laravel">Laravel</a></li>
                        <li><a href="https://github.com/twbs/bootstrap">Bootstrap</a></li>
                        <li><a href="https://github.com/vuejs/vue">Vue</a></li>
                        <li><a href="https://github.com/jquery/jquery">jQuery</a></li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
