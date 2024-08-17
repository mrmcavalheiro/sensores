@extends('site.layout')
@section('title','Página Contato')
@section('content')

<!-- Título Apoiadores com Fundo Azul -->
<div class="quaseMenu">
    Entre em Contato
</div>


    <div class="row container">
        <div class="col s12">
            <div class="col s12 l6 push-l3 center-align">
                <p>Estamos aqui para ajudar! Você pode entrar em contato conosco através dos seguintes meios:</p>
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
