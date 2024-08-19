@php
    use App\Models\SistemaGlobal;
    $menu = SistemaGlobal::$Menu;
    $itens = $menu['itens'];
    $icons = $menu['icons'];
    $rotas = $menu['rotas'];
@endphp

<footer class="page-footer blue">
    <div class="container">
        <section class="row">
            <div class="col s12 m3 center-align">
                <a href="https://unijui.edu.br" target="_blank">
                    <img src="https://www.unijui.edu.br/templates/template_unijui2016/images/logo-rodape-bco.png"
                        class="d-inline-block align-center" alt="Logo UNIJUÍ" loading="lazy"
                        style="margin-top: 17px;">
                </a>
            </div>

            <div class="col s12 m4 center-align">
                <p><b>Contato</b><br>Escritório de Relações Universidade - Comunidade</p>
                <p><i class="material-icons small">phone</i> <b>Telefones:</b><br>(55) 3332-0368</p>
                <p><i class="material-icons small">email</i><b> Email:</b><br><a class="white-text"
                        href="mailto:comunidade@unijui.edu.br">comunidade@unijui.edu.br</a></p>
            </div>
            <div class="col s12 m5 center-align">
                <div class="row">
                    <div class="col s6">
                        <ul>
                            @foreach ($itens as $key => $item)
                                @if($key < count($itens) / 2)
                                    <li>
                                        <a href="{{ route($rotas[$key]) }} " class="white-text">
                                            <i class="{{ $icons[$key] }} fa-1x"></i><b>
                                                {{ $item }}</b> <br>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col s6">
                        <ul>
                            @foreach ($itens as $key => $item)
                                @if($key >= count($itens) / 2)
                                    <li>
                                        <a href="{{ route($rotas[$key]) }} " class="white-text">
                                            <i class="{{ $icons[$key] }} fa-1x"></i><b>
                                                {{ $item }}</b> <br>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="container center-align all_rights_reserved">
        <p>&copy; {{ date('Y') }} - Todos os direitos reservados.</p>
    </div>
</footer>
