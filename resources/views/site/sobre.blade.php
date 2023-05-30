@extends('site.layout')
@section('title','Página Sobre')
@section('content')
    {{-- cards-objetivos --}}
    @include('partials.sobre.apresentacao')
    {{-- parallax --}}
    @include('partials.sobre.parallax')
@endsection
