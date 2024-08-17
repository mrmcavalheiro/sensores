@extends('site.layout')
@section('title','Página Sobre')
@section('content')

    {{-- cards-Equipe --}}
    @include('partials.equipe.apresentacao')

    {{-- cards-Equipe --}}
    @include('partials.equipe.membros')

    {{-- parallax --}}
    @include('partials.equipe.parallax')
@endsection
