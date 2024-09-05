@extends('site.layout')
@section('title','Página Análise de Solo')
@section('content')
    {{-- cards-objetivos --}}
    {{-- @include('partials.solo.apresentacao') --}}
    
    {{-- 
    @if(isset($regioes) && $regioes->isNotEmpty())
        @include('partials.solo.analises', ['regioes' => $regioes])
    @else
        <p>Nenhuma análise de solo disponível no momento.</p>
    @endif
    --}}

    @if(empty($regioes))
        <?php log::info('3 - Dados das regi%C3%B5es carregados:', ['regioes' => $regioes]); ?>
        <?php Log::warning('Nenhuma análise de solo disponível no momento. Regiões vazias.'); ?>
        <p>Nenhuma análise de solo disponível no momento.</p>
    @else
        <?php Log::info('Exibindo análises de solo para as regiões.', ['regioes' => $regioes]); ?>
        @include('partials.solo.analises', ['regioes' => $regioes])
    @endif

    {{-- parallax --}}
    @include('partials.solo.parallax')
@endsection
