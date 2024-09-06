@extends('site.layout')
@section('title','Página Boletins')
@section('content')

    {{-- cards-Boletins --}}
    @include('partials.boletins.boletins')
    
    {{-- Explicação --}}
    @include('partials.boletins.explicacao')

    {{-- Parallax --}}
    @include('partials.boletins.parallax')

@endsection