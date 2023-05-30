@extends('site.layout')
@section('title','Página Home')
@section('content')

{{-- cards-home --}}
@include('partials.home.cards')
{{-- parallax --}}
@include('partials.home.parallax')
{{-- team --}}
@include('partials.home.team')

@endsection
