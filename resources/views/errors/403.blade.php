@extends('errors::layout')

@section('title', 'Forbidden')
@section('code', '403')
@section('message', 'Access Denied')
@section('exception', 'You do not have permission to access this resource.')
@section('icon')
    <i class="fas fa-lock text-4xl text-orange-400"></i>
@endsection
