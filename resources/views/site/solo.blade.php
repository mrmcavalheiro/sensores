@extends('site.layout')
@section('title','Página Análise de Solo')
@section('content')
    {{-- cards-objetivos --}}
    {{-- @include('partials.solo.apresentacao') --}}
    
    @if(isset($regioes) && $regioes->isNotEmpty())
        @include('partials.solo.analises', ['regioes' => $regioes])
    @else
        <p>Nenhuma análise de solo disponível no momento.</p>
    @endif

    {{-- parallax --}}
    @include('partials.solo.parallax')
@endsection
