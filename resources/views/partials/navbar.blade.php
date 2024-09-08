@php
    use App\Models\SistemaGlobal;
    $menu = SistemaGlobal::$Menu;
    $itens = $menu['itens'];
    $subMenus = $menu['subMenus'];
    $icons = $menu['icons'];
    $rotas = $menu['rotas'];
    $rotaPrincipal = $menu['rota_principal'];
@endphp

<nav class="blue">
    <div class="nav-warpper container">
        {{-- Menu Hamburger --}}
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons small-text">menu</i></a>

        <a href="{{ route($rotaPrincipal) }}" class="brand-logo light">
            <img class="brand-logo-images" src="{{ asset('images/logos/logo_projeto.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}">
            <span class="app_name">{{ config('app.name') }}</span>
        </a>
        {{-- Menu para desktop --}}
        <ul class="right hide-on-med-and-down">
            @foreach ($itens as $key => $item)
                @if (isset($subMenus[$key]) && count($subMenus[$key]) > 0)
                    <li>
                        <a class="dropdown-trigger {{ Request::routeIs($rotas[$key]) ? 'active' : '' }}" data-target="{{ 'dropdown_menu' . $key }}">
                            <i class="{{ $icons[$key] }} fa-1x"></i>
                            {{ $item }}
                        </a>
                    </li>
                    <ul id="{{ 'dropdown_menu' . $key }}" class="dropdown-content sub_menu-content">
                        @foreach ($subMenus[$key] as $subItem)
                            <li>
                                <a href="{{ route($rotas[$key]) . $subItem['rota'] }}">
                                    {{ $subItem['nome'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <li>
                        <a href="{{ route($rotas[$key]) }}" class="{{ Request::routeIs($rotas[$key]) ? 'active' : '' }}">
                            <i class="{{ $icons[$key] }} fa-1x"></i>
                            {{ $item }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Menu Mobile --}}
        <ul id="slide-out" class="sidenav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="{{ asset('images/slide/sidenav-imagem.jpg') }}" alt="[imagem]"
                            title='{{ config('app.name') }}'>
                    </div>
                    {{-- <a href="#user"><img class="circle" src="images/yuna.jpg"></a> --}}
                    <a href="#name"><span class="white-text name m0 line_height_big"><b>{{ config('app.name') }}</b></span></a>
                    {{-- <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a> --}}
                </div>
             </li>

            <li><div class="divider"></div></li>
            <li>
                <a href="{{ route($rotaPrincipal) }}">
                    <i class="fas fa-home fa-1x blue-text text-lighten-4"></i><b>
                    Home</b> <br>
                </a>
            </li>
            @foreach ($itens as $key => $item)
                <li>
                    <a href="{{ route($rotas[$key]) }}" class="{{ Request::routeIs($rotas[$key]) ? 'active' : '' }}">
                        <i class="{{ $icons[$key] }} fa-1x blue-text text-lighten-4"></i><b>
                        {{ $item }}</b> <br>
                    </a>
                </li>
            @endforeach

        </ul>

    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {

    // Inicialização do dropdown
    const elems = document.querySelectorAll('.dropdown-trigger');
    const instances = M.Dropdown.init(elems, { hover: false, constrainWidth: false });
});
</script>
