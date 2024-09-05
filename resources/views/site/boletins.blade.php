@extends('site.layout')
@section('title','Página Boletins')
@section('content')

    {{-- cards-Boletins --}}
    @include('partials.boletins.boletins')

    {{-- Parallax --}}
    @include('partials.boletins.parallax')

@endsection