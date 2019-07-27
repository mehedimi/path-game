@extends('layouts.app')

@section('content')
    <div>
        <invite></invite>
        <div>
            <invitation user-id="{{ auth()->id() }}"></invitation>
        </div>
    </div>
@endsection
