<div class="row container">
    <p class="flow-text black-text">
        {{ \App\Http\Controllers\SoloController::$paginaSolo['tituloAnaliseFisica'] }} <br>
    </p>
    <div class="col s12 p0">
        <ul class="collapsible collapsible_b1">
            @foreach ($regioes as $regiao_nome => $municipios)
                <li>
                    <div class="collapsible-header collapsible_header_b1">
                        <div class="row m0 w100">
                            <div class="col s11">
                                <b>Região: {{ $regiao_nome }}</b>
                            </div>
                            <div class="col s1">
                                <i class="material-icons arrow_not_active">keyboard_arrow_down</i>
                                <i class="material-icons arrow_active">keyboard_arrow_up</i>
                            </div>
                        </div>
                    </div>
                    <div class="collapsible-body collapsible-body_low_padding">
                        <ul class="collapsible collapsible_b2">
                            @foreach ($municipios->groupBy('municipio_nome') as $municipio_nome => $produtores)
                                <li>
                                    <div class="collapsible-header collapsible_header_b2">
                                        <div class="row m0 w100">
                                            <div class="col s11">
                                                <b>Município: {{ $municipio_nome }}</b>
                                            </div>
                                            <div class="col s1">
                                                <i class="material-icons arrow_not_active">keyboard_arrow_down</i>
                                                <i class="material-icons arrow_active">keyboard_arrow_up</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapsible-body collapsible-body_low_padding">
                                        <ul class="collapsible collapsible_b3">
                                            @foreach ($produtores->groupBy('produtor_nome') as $produtor_nome => $analises)
                                                <li>
                                                    <div class="collapsible-header collapsible_header_b3">
                                                        <div class="row m0 w100">
                                                            <div class="col s11">
                                                                <b>Produtor: {{ $produtor_nome }} ({{ $analises->first()->nome_fantasia }})</b>
                                                            </div>
                                                            <div class="col s1">
                                                                <i class="material-icons arrow_not_active">keyboard_arrow_down</i>
                                                                <i class="material-icons arrow_active">keyboard_arrow_up</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapsible-body collapsible-body_low_padding">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <ul class="tabs">
                                                                    <li class="tab col s6"><a class="highlighted" href="#analise_quimica_{{ $loop->parent->parent->index }}_{{ $loop->index }}">Análise Química</a></li>
                                                                    <li class="tab col s6"><a class="highlighted" href="#analise_fisica_{{ $loop->parent->parent->index }}_{{ $loop->index }}">Análise Física</a></li>
                                                                </ul>
                                                            </div>

                                                            <!-- Conteúdo da Análise Química -->
                                                            <div id="analise_quimica_{{ $loop->parent->parent->index }}_{{ $loop->index }}" class="col s12">
                                                                <table class="highlight responsive-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Parâmetro</th>
                                                                            <th>Unidade</th>
                                                                            <th>0-20 cm</th>
                                                                            <th>20-40 cm</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr><td>Argila</td><td>%</td><td>{{ $analises->first()->argila_quimica_0_20 }}</td><td>{{ $analises->first()->argila_quimica_20_40 }}</td></tr>
                                                                        <tr><td>pH</td><td></td><td>{{ $analises->first()->ph_quimica_0_20 }}</td><td>{{ $analises->first()->ph_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Fósforo</td><td>mg/dm³</td><td>{{ $analises->first()->fosforo_quimica_0_20 }}</td><td>{{ $analises->first()->fosforo_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Potássio</td><td>mg/dm³</td><td>{{ $analises->first()->potassio_quimica_0_20 }}</td><td>{{ $analises->first()->potassio_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Matéria Orgânica</td><td>%</td><td>{{ $analises->first()->materia_organica_quimica_0_20 }}</td><td>{{ $analises->first()->materia_organica_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Alumínio</td><td>cmolc/dm³</td><td>{{ $analises->first()->aluminio_quimica_0_20 }}</td><td>{{ $analises->first()->aluminio_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Cálcio</td><td>cmolc/dm³</td><td>{{ $analises->first()->calcio_quimica_0_20 }}</td><td>{{ $analises->first()->calcio_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Magnésio</td><td>cmolc/dm³</td><td>{{ $analises->first()->magnesio_quimica_0_20 }}</td><td>{{ $analises->first()->magnesio_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Ca/Mg</td><td> </td><td>{{ $analises->first()->ca_mg_quimica_0_20 }}</td><td>{{ $analises->first()->ca_mg_quimica_20_40 }}</td></tr>
                                                                        <tr><td>H + Al</td><td>cmolc/dm³</td><td>{{ $analises->first()->h_al_quimica_0_20 }}</td><td>{{ $analises->first()->h_al_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Cobre</td><td>mg/dm³</td><td>{{ $analises->first()->cobre_quimica_0_20 }}</td><td>{{ $analises->first()->cobre_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Zinco</td><td>mg/dm³</td><td>{{ $analises->first()->zinco_quimica_0_20 }}</td><td>{{ $analises->first()->zinco_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Manganês</td><td>mg/dm³</td><td>{{ $analises->first()->manganes_quimica_0_20 }}</td><td>{{ $analises->first()->manganes_quimica_20_40 }}</td></tr>
                                                                        <tr><td>Enxofre</td><td>mg/dm³</td><td>{{ $analises->first()->enxofre_quimica_0_20 }}</td><td>{{ $analises->first()->enxofre_quimica_20_40 }}</td></tr>
                                                                        <!-- Adicione outros parâmetros químicos conforme necessário -->
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Conteúdo da Análise Física -->
                                                            <div id="analise_fisica_{{ $loop->parent->parent->index }}_{{ $loop->index }}" class="col s12">
                                                                <table class="highlight responsive-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Parâmetro</th>
                                                                            <th>Unidade</th>
                                                                            <th>0-20 cm</th>
                                                                            <th>20-40 cm</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr><td>Areia</td><td>%</td><td>{{ $analises->first()->areia_fisica_0_20 }}</td><td>{{ $analises->first()->areia_fisica_20_40 }}</td></tr>
                                                                        <tr><td>Argila</td><td>%</td><td>{{ $analises->first()->argila_fisica_0_20 }}</td><td>{{ $analises->first()->argila_fisica_20_40 }}</td></tr>
                                                                        <tr><td>Silte</td><td>%</td><td>{{ $analises->first()->silte_fisica_0_20 }}</td><td>{{ $analises->first()->silte_fisica_20_40 }}</td></tr>
                                                                        <tr><td>Tipo do Solo</td><td></td><td>{{ $analises->first()->tipo_solo_fisica_0_20 }}</td><td>{{ $analises->first()->tipo_solo_fisica_20_40 }}</td></tr>
                                                                        <tr><td>Classe Textural</td><td></td><td>{{ $analises->first()->classe_textural_fisica_0_20 }}</td><td>{{ $analises->first()->classe_textural_fisica_20_40 }}</td></tr>
                                                                        <tr><td>AD Predita</td><td></td><td>{{ $analises->first()->ad_predita_fisica_0_20 }}</td><td>{{ $analises->first()->ad_predita_fisica_20_40 }}</td></tr>
                                                                        <tr><td>Classe AD</td><td></td><td>{{ $analises->first()->classe_ad_fisica_0_20 }}</td><td>{{ $analises->first()->classe_ad_fisica_20_40 }}</td></tr>
                                                                        <tr><td>AD2</td><td></td><td>{{ $analises->first()->ad2_fisica_0_20 }}</td><td>{{ $analises->first()->ad2_fisica_20_40 }}</td></tr>
                                                                        <!-- Adicione outros parâmetros físicos conforme necessário -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tabs');
        var instances = M.Tabs.init(elems);

        var collapsibles = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(collapsibles);
    });
</script>
