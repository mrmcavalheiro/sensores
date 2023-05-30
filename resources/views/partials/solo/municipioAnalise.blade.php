<div class="divider"></div>
<table>
    <thead>
        <tr>
            <th>Nome do Município</th>
            <th>Total de Análises</th>
        </tr>
    </thead>
    <tbody>
        @foreach (\App\Http\Controllers\SoloController::$paginaSolo[0]['municipios'] as $municipio)
        <tr>
            <td>{{ $municipio['nomeMunicipio'] }}</td>
            <td>{{ $municipio['totalAnalise'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
