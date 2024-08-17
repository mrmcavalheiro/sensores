<!-- Título  com Fundo Azul -->
<div class="quaseMenu">
    {{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['tituloPagina'] }}
</div>

<div class="row container">
    <div class="col s12">
        <section class="col s12 l6 push-l3 center-align">

            <p class="flow-text justify black-text">
                {{ \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0]['apresentacao'] }}
            </p>
        </section>
    </div>
</div>
<br>
<div class="row container">
    <div class="row">
        <section class="col s12">
            <h2 class="flow-text blue-text">
                {{ \App\Models\SistemaGlobal::$paginaSobre['sobreData'][0]['titulo'] }}
            </h2>
            <p class="flow-text justify black-text">
                {{ \App\Models\SistemaGlobal::$paginaSobre['sobreData'][0]['texto'] }}
            </p>
        </section>
    </div>
    <div class="row">
        <section class="col s12">
            <h2 class="flow-text blue-text">
                {{ \App\Models\SistemaGlobal::$paginaSobre['sobreData'][1]['titulo'] }}
            </h2>
            <p class="flow-text justify black-text">
                {{ \App\Models\SistemaGlobal::$paginaSobre['sobreData'][1]['texto'] }}
            </p>
        </section>
    </div>

    @foreach (\App\Models\SistemaGlobal::$paginaSobre['sobreData'] as $index => $data)
        @if ($index > 1)
            <div class="row">
                <section class="col s12">
                    <a href="{{ route($data['rota']) }}">
                        <div class="card hoverable">
                            <div class="card-content">
                                <span class="card-title flow-text blue-text"><b>{{ $data['titulo'] }}</b></span>
                                <p class="flow-text justify black-text">{{ $data['texto'] }}</p>
                            </div>
                        </div>
                    </a>
                </section>
            </div>
        @endif
    @endforeach
</div>
