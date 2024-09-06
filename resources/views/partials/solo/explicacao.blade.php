@php
    $paginaSolo = \App\Http\Controllers\SoloController::$paginaSolo;
    function replace_br_with_paragraphs($text) {
        return preg_replace('/<br\\s*\/?>/', '</p><p class="justify">', $text);
    }
@endphp

<div class="container texto_explicativo">
    <h5 class="bold">{{ $paginaSolo['explicacaoTitulo'] }}</h5>
    <p class="justify">{!! replace_br_with_paragraphs($paginaSolo['explicacao']) !!}</p>
</div>