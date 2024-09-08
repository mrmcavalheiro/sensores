@php
    $paginaSolo = \App\Http\Controllers\SoloController::$paginaSolo;
    function replace_br_with_paragraphs($text) {
        return preg_replace('/<br\\s*\/?>/', '</p><p class="justify">', $text);
    }
@endphp

<div class="container">
    <h5 class="bold">{{ $paginaSolo['explicacaoTitulo'] }}</h5>
    
    <div class="explicativo_com_imagem">
        <img src="{{ asset('images/solo/' . $paginaSolo['explicacao_1_imagem']) }}" alt="{{ $paginaSolo['explicacao_1_imagem_alt'] }}" title="{{ $paginaSolo['explicacao_1_imagem_alt'] }}">
        <p class="justify m0">{!! replace_br_with_paragraphs($paginaSolo['explicacao_1']) !!}</p>
    </div>
    <p class="justify m0">{!! replace_br_with_paragraphs($paginaSolo['explicacao_2']) !!}</p>
</div>