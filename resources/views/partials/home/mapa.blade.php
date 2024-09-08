@php
    $paginaRegioes = \App\Models\SistemaGlobal::$paginaRegioes[0];
    function replace_br_with_paragraphs($text) {
        return preg_replace('/<br\\s*\/?>/', '</p><p class="justify m0">', $text);
    }
@endphp

<section class="content-section">
    <div class="row">
        <div class="col s12">
            <div class="new_card">
                <div class="row">
                    <div class="col s12 center-align">
                        <h5>{{ $paginaRegioes['tituloRegioes'] }}</h5>
                    </div>

                    <div class="col s12 m6">
                        <img class="w100" src=" {{asset('images/projeto/' . $paginaRegioes['regioes_imagem'])}} " alt="mapa_das_regioes">
                    </div>
                    <div class="col s12 m6 align_self_center">
                        <div class="regioes_wrapper">
                            @foreach($regions as $index => $region)
                                <div class="regiao_wrapper">
                                    <div class="regiao_cor" style="background-color: {{$region['color']}};"></div>
                                    <div class="regiao_nome">{{ $region['description'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="explicativo_regioes">        
                    <p class="justify m0">{!! replace_br_with_paragraphs($paginaRegioes['explicacao']) !!}</p>
                </div>
            </div>
        </div>
    </div>

</section>