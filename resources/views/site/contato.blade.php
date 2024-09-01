@extends('site.layout')
@section('title','Página Contato')
@section('content')

<!-- Título Apoiadores com Fundo Azul -->
<div class="row container">
    {{-- cards-Parte1 --}}
    @include('partials.contato.container')
    {{-- cards-Parte2 --}}
    {{-- @include('partials.contato.parte2') --}}
    {{-- cards-Formulário de Contato --}}
    {{-- @include('partials.contato.formularioContato') --}}
</div>

{{-- parallax --}}
@include('partials.contato.parallax')

@endsection
