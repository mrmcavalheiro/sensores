@extends('site.layout')
@section('title','Página Análise de Solo')
@section('content')
    {{-- cards-objetivos --}}
    @include('partials.solo.apresentacao')

    @include('partials.solo.analises')

    {{-- parallax --}}
    @include('partials.solo.parallax')

@endsection
