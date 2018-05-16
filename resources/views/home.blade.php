@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <posts-component></posts-component>
        </div>
        <div class="col-md-4">
            <div class="card text-center rounded-0">

                <div class="card-body">
                    <h5 class="card-title">Awesome Comments Collection</h5>
                    <p class="card-text">
                        Make your favorite comments persist forever.
                    </p>
                    <a href="/post-create" class="btn btn-primary">Contribute</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
