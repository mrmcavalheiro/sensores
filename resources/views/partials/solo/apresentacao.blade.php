<!-- Título  com Fundo Azul -->
<div class="quaseMenu">
    {{ \App\Http\Controllers\SoloController::$paginaSolo[0]['tituloPagina'] }}
</div>
<div class="row container">
    <div class="col s12">
        <section class="col s12 l6 push-l3 center-align">
            <p class="flow-text justify black-text">
                {{ \App\Http\Controllers\SoloController::$paginaSolo[0]['apresentacao'] }}
            </p>
        </section>
    </div>
</div>
<div class="divider"></div>
