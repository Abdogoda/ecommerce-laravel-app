@extends('errors::layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('message', 'Slow Down')
@section('exception', 'You\'re making requests too quickly. Please wait a moment and try again.')
@section('icon')
    <i class="fas fa-hourglass-end text-4xl text-yellow-400"></i>
@endsection
