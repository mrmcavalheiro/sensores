<section class="contato_full_container">
    <div class="contato_container p0 m0 row w100">
        <div class="col s12 m6 p0 m0">
            {{-- cards-informacoes --}}
            @include('partials.contato.informacoes')
        </div>
        <div class="col s12 m6 p0 m0 contato_formulario_container hide_on_mobile">
            {{-- cards-Formulário de Contato --}}
            @include('partials.contato.formularioContato')
        </div>
    </div>

    <div class="col s12 p0 m0">
        {{-- cards-Mapa --}}
        @include('partials.contato.mapa')
    </div>
</section>
