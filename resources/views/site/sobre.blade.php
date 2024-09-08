@extends('site.layout')
@section('title','Página Sobre')
@section('content')
    {{-- cards-objetivos --}}
    <section id="sobre">
        @include('partials.sobre.apresentacao')
    </section>

    <section id="equipe">
        {{-- cards-Equipe --}}
        @include('partials.equipe.apresentacao')
            
        {{-- cards-Equipe --}}
        @include('partials.equipe.membros')

        {{-- Apresentação da equipe de desenvolvimento --}}
        @include('partials.projeto.apresentacao')

        {{-- cards-Equipe de desenvolvimento --}}
        @include('partials.projeto.membros')
    </section>

    <section id="realizadores">
        {{-- Apresentação dos realizadores --}}
        @include('partials.realizadores.apresentacao')
    
        {{-- Cards dos realizadores --}}
        @include('partials.realizadores.realizadores')
    </section>

    <section id="apoiadores">
            {{-- Apresentação dos apoiadores --}}
            @include('partials.apoiadores.apresentacao')
        
            {{-- Cards dos apoiadores --}}
            @include('partials.apoiadores.apoiadores')
    </section>

    {{-- parallax --}}
    @include('partials.sobre.parallax')
@endsection
