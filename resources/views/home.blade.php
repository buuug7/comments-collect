@extends('layouts.app')

@section('content')
<div class="container">
    <post-component :id="1"></post-component>
    <post-component :id="2"></post-component>
    <post-component :id="3"></post-component>
</div>
@endsection
