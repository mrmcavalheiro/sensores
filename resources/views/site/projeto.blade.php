@extends('site.layout')
@section('title','Página Projeto')
@section('content')
    <div class="projeto_container">
        {{-- cards-Equipe --}}
        @include('partials.equipe.apresentacao')
        
        {{-- cards-Equipe --}}
        @include('partials.equipe.membros')
        
        {{-- Apresentação da equipe de desenvolvimento --}}
        @include('partials.projeto.apresentacao')
        
        {{-- cards-Equipe de desenvolvimento --}}
        @include('partials.projeto.membros')
        
        {{-- Apresentação dos apoiadores --}}
        @include('partials.apoiadores.apresentacao')
        
        {{-- Cards dos apoiadores --}}
        @include('partials.apoiadores.apoiadores')
        
        {{-- parallax --}}
        @include('partials.equipe.parallax')
    </div>
@endsection
