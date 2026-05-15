@extends('errors::layout')

@section('title', 'Page Not Found')
@section('code', '404')
@section('message', 'Page Not Found')
@section('exception', 'We couldn\'t find the page you\'re looking for. It might have been moved or deleted.')
@section('icon')
    <i class="fas fa-map-location-dot text-4xl text-blue-400"></i>
@endsection
