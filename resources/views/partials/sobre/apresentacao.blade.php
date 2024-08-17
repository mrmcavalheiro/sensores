<div class="quaseMenu">
    {{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['tituloPagina'] }}
</div>

<div class="container">
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['apresentacao'] }}</p>

    <h1 class="titulo-projeto">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['projeto'] }}</h1>

    <h4 class="bold">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['tituloJustificativa'] }}</h4>
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['textoJustificativa'] }}</p>

    <h4 class="bold">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['tituloObjetivosEspecíficos'] }}</h4>
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['textoObjetivosEspecíficos-a'] }}</p>
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['textoObjetivosEspecíficos-b'] }}</p>
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['textoObjetivosEspecíficos-c'] }}</p>


    <h4 class="bold">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['tituloEstrutura'] }}</h4>
    <p class="justify">{{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['textoEstrutura'] }}</p>
    @foreach (\App\Models\SistemaGlobal::$paginaSobre['sobreData'] as $index => $data)
    @if ($index > 1)
        <div class="row">
            <section class="col s12">
                <a href="{{ route($data['rota']) }}">
                    <div class="card hoverable">
                        <div class="card-content">
                            <span class="card-title flow-text blue-text"><b>{{ $data['titulo'] }}</b></span>
                            <p class="flow-text justify black-text justify">{{ $data['texto'] }}</p>
                        </div>
                    </div>
                </a>
            </section>
        </div>
    @endif
@endforeach

</div>
