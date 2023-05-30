<div class="divider"></div>
<table>
    <thead>
        <tr>
            <th>Código Município</th>
            <th>Nome Município</th>
            <th>Total Análises</th>
            <th>Textura do Solo</th>
            <th>pH do Solo</th>
            <th>Matéria Orgânica</th>
            <th>Capacidade de Troca de Cátions</th>
            <th>Teores de Nutrientes</th>
            <th>Teor de Matéria Seca</th>
            <th>Teor de Carbono Orgânico</th>
            <th>Densidade do Solo</th>
            <th>Porosidade do Solo</th>
            <th>Condutividade Elétrica</th>
        </tr>
    </thead>
    <tbody>
        @foreach (\App\Http\Controllers\SoloController::$paginaSolo[0]['municipios'] as $municipio)
            @foreach ($municipio['analises'] as $analise)
            <tr>
                <td>{{ $municipio['codigoMunicipio'] }}</td>
                <td>{{ $municipio['nomeMunicipio'] }}</td>
                <td>{{ $municipio['totalAnalise'] }}</td>
                <td>{{ $analise['textura_solo'] }}</td>
                <td>{{ $analise['ph_solo'] }}</td>
                <td>{{ $analise['materia_organica'] }}</td>
                <td>{{ $analise['capacidade_troca_cations'] }}</td>
                <td>
                    <ul>
                        @foreach ($analise['teores_nutrientes'] as $nutriente => $valor)
                            <li>{{ ucfirst($nutriente) }}: {{ $valor }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $analise['teor_materia_seca'] }}</td>
                <td>{{ $analise['teor_carbono_organico'] }}</td>
                <td>{{ $analise['densidade_solo'] }}</td>
                <td>{{ $analise['porosidade_solo'] }}</td>
                <td>{{ $analise['condutividade_eletrica'] }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
