@extends('errors::layout')

@section('title', 'Server Error')
@section('code', '500')
@section('message', 'Server Error')
@section('exception', 'An unexpected error occurred on our end. Please try again later or contact support.')
@section('icon')
    <i class="fas fa-triangle-exclamation text-4xl text-red-400"></i>
@endsection
