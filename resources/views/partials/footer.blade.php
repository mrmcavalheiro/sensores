@php
    use App\Models\SistemaGlobal;
    $menu = SistemaGlobal::$Menu;
    $itens = $menu['itens'];
    $icons = $menu['icons'];
    $rotas = $menu['rotas'];
@endphp

<footer class="page-footer blue">
    <div class="container">
        <section class="align_center footer_container">
            <div class="center-align">
                <a href="https://unijui.edu.br" target="_blank">
                    <img src="https://www.unijui.edu.br/templates/template_unijui2016/images/logo-rodape-bco.png"
                        class="d-inline-block align-center" alt="Logo UNIJUÍ" loading="lazy"
                        style="margin-top: 17px;">
                </a>
            </div>

            <div class="footer_info_wrapper">
                <p><b>Escritório de Relações Universidade - Comunidade</b></p>
                <p class="footer_info"><i class="material-icons small">phone</i> <b>Telefone: </b> (55) 3332-0368</p>
                <p class="footer_info">
                    <i class="material-icons small">email</i>
                    <b> Email:</b>
                    <a class="white-text"href="mailto:comunidade@unijui.edu.br">comunidade@unijui.edu.br</a>
                </p>
            </div>
            <div class="footer_menu_links">
                @foreach ($itens as $key => $item)
                    <a href="{{ route($rotas[$key]) }}" class="footer_menu_link">
                        <i class="{{ $icons[$key] }} fa-1x"></i>
                        <b>{{ $item }}</b>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <div class="container center-align all_rights_reserved">
        <p>&copy; {{ date('Y') }} - Todos os direitos reservados.</p>
    </div>
</footer>
