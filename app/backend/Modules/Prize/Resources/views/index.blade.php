@extends('prize::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('prize.name') !!}
    </p>
@endsection
