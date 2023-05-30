@extends('site.layout')
@section('title','Página Contato')
@section('content')
    <div class="row container">
        <div class="col s12">
            <div class="col s12 l6 push-l3 center-align">
                <h1 class="flow-text blue-text">Entre em Contato</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi ut nam dignissimos neque quidem, officiis quasi porro natus excepturi quibusdam, tempore expedita voluptate, earum minima? Facere saepe soluta corporis quis!</p>
            </div>
        </div>
        {{-- cards-Parte1 --}}
        @include('partials.contato.parte1')
        {{-- cards-Parte2 --}}
        @include('partials.contato.parte2')
        {{-- cards-Formulário de Contato --}}
        @include('partials.contato.formularioContato')
    </div>
    {{-- parallax --}}
    @include('partials.contato.parallax')

@endsection
