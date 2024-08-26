@php
function replace_br_with_paragraphs($text) {
    return preg_replace('/<br\\s*\/?>/', '</p><p class="flow-text justify black-text descricao-container">', $text);
}
@endphp

<div class="row container apoiador_main_container">
    @foreach ($apoiadores as $index => $apoiador)
        <div class="apoiador_container m0">
            <a href="{{ $apoiador['website'] }}" target="_blank">
                <img 
                    src="{{ asset('images/parceiros/patrocinadores/' . $apoiador['logo']) }}"
                    alt="{{ $apoiador['nome'] }}"
                    title="{{ config('app.name') }}" 
                    class="{{ $apoiador['imageOrientation'] }}">
            </a>
        </div>
    @endforeach
</div>
{{-- 
<div class="row container">
    @foreach ($apoiadores as $index => $apoiador)
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title apoiador-nome"><b>{{ $apoiador['nome'] }}</b></span>
                    <div class="row">
                        @if ($index % 2 == 0)
                            <div class="col s12 m8 l8">
                                <div class="flow-text justify black-text descricao-container">
                                    {!! replace_br_with_paragraphs($apoiador['descricao']) !!}
                                </div>
                            </div>
                            <div class="col s12 m4 l4">
                                <div class="card-image">
                                    <a href="{{ $apoiador['website'] }}" target="_blank">
                                        <img src="{{ asset('images/parceiros/patrocinadores/' . $apoiador['logo']) }}" alt="{{ $apoiador['nome'] }}">
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="col s12 m4 l4">
                                <div class="card-image img-direita">
                                    <a href="{{ $apoiador['website'] }}" target="_blank">
                                        <img src="{{ asset('images/parceiros/patrocinadores/' . $apoiador['logo']) }}" alt="{{ $apoiador['nome'] }}" title="{{ config('app.name') }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col s12 m8 l8">
                                <div class="flow-text justify black-text descricao-container">
                                    {!! replace_br_with_paragraphs($apoiador['descricao']) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-action center-align">
                    <a href="{{ $apoiador['website'] }}" target="_blank">Visitar Site</a>
                </div>
            </div>
        </div>
    @endforeach
</div> --}}
