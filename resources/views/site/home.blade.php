@extends('site.layout')
@section('title','Página Home')
@section('content')

{{-- cards-home --}}
@include('partials.home.apresentacao')
{{-- parallax --}}
@include('partials.home.parallax')


@endsection
