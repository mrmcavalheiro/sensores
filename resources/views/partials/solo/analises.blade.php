<div class="row container">
    <section class="row center-align">
        <p class="flow-text text-center blue-text">
            Relação de Municípios e Análise de Solo
        </p>
    </section>

    <div class="col s12">
        <ul class="collapsible">
            @foreach (\App\Http\Controllers\SoloController::$paginaSolo[0]['municipios'] as $municipio)
            <li>
                <div class="collapsible-header">
                    <div class="row center-align">
                        <div class="col s12">
                            <b>{{ $municipio['nomeMunicipio'] }}</b>
                            <span class="total-analises">({{ $municipio['totalAnalise'] }} análises)</span>
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
