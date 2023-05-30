@extends('site.layout')
@section('title','Página solo')
@section('content')
    {{-- cards-objetivos --}}
    @include('partials.solo.apresentacao')

    @include('partials.solo.analises')

    {{-- parallax --}}
    @include('partials.solo.parallax')

@endsection
