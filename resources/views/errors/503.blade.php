@extends('errors::layout')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('message', 'Service Unavailable')
@section('exception', 'We\'re performing maintenance. Please check back shortly.')
@section('icon')
    <i class="fas fa-server text-4xl text-red-400"></i>
@endsection
