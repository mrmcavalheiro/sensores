@extends('site.layout')
@section('title', 'Página de Apoiadores')
@section('content')
    {{-- Apresentação dos apoiadores --}}
    @include('partials.apoiadores.apresentacao')

    {{-- Cards dos apoiadores --}}
    @include('partials.apoiadores.apoiadores')

    {{-- Parallax --}}
    @include('partials.apoiadores.parallax')
@endsection
