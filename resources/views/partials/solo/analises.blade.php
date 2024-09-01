<div class="row container">
    <section class="center-align">
        <p class="flow-text text-center black-text">
            Relação de municípios e análises de solo
        </p>
    </section>

    <div class="col s12 p0">
        <ul class="collapsible">
            @foreach (\App\Http\Controllers\SoloController::$paginaSolo[0]['municipios'] as $municipio)
            <li>
                <div class="collapsible-header">
                    <div class="row m0 w100">
                        <div class="col s11">
                            <b>{{ $municipio['nomeMunicipio'] }}</b>
                            <span class="total-analises">({{ $municipio['totalAnalise'] }} análises)</span>
                        </div>
                        <div class="col s1">
                            <i class="material-icons arrow_not_active">keyboard_arrow_down</i>
                            <i class="material-icons arrow_active">keyboard_arrow_up</i>
                        </div>
                    </div>
                </div>


                <div class="collapsible-body">
                    <div class="responsive-table">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Informações da Análise</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($municipio['analises'] as $analise)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>Textura do Solo:</strong> {{ $analise['textura_solo'] }}
                                        </div>
                                        <div>
                                            <strong>pH do Solo:</strong> {{ $analise['ph_solo'] }}
                                        </div>
                                        <div>
                                            <strong>Matéria Orgânica:</strong> {{ $analise['materia_organica'] }}
                                        </div>
                                        <div>
                                            <strong>Capacidade de Troca de Cátions:</strong> {{ $analise['capacidade_troca_cations'] }}
                                        </div>
                                        <div>
                                            <strong>Teores de Nutrientes:</strong>
                                            <ul>
                                                @foreach ($analise['teores_nutrientes'] as $nutriente => $valor)
                                                <li>
                                                    <span class="subitem-marker">&bull;</span> {{ ucfirst($nutriente) }}: {{ $valor }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            <strong>Teor de Matéria Seca:</strong> {{ $analise['teor_materia_seca'] }}
                                        </div>
                                        <div>
                                            <strong>Teor de Carbono Orgânico:</strong> {{ $analise['teor_carbono_organico'] }}
                                        </div>
                                        <div>
                                            <strong>Densidade do Solo:</strong> {{ $analise['densidade_solo'] }}
                                        </div>
                                        <div>
                                            <strong>Porosidade do Solo:</strong> {{ $analise['porosidade_solo'] }}
                                        </div>
                                        <div>
                                            <strong>Condutividade Elétrica:</strong> {{ $analise['condutividade_eletrica'] }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const elems = document.querySelectorAll('.collapsible');
        const instances = M.Collapsible.init(elems, { accordion: true });
    });
</script>