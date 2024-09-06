<?php
    $paginaSobre = \App\Models\SistemaGlobal::$paginaSobre['paginaSobre'][0];
?>

<div class="container sobre_container">
    <div class="sobre_conjunto">
        <h5 class="bold">{{ $paginaSobre['projeto_sobre'] }}</h5>
        <p class="justify"><b>{{$paginaSobre['projeto_sobre_titulo']}}</b>{{ $paginaSobre['projeto_sobre_texto'] }}</p>
    </div>

    <div class="sobre_conjunto">
        <h5 class="bold">{{ $paginaSobre['projeto_sensores'] }}</h5>
        <p class="justify"><b>{{$paginaSobre['projeto_sensores_justificativa_titulo']}}</b>{{ $paginaSobre['projeto_sensores_justificativa_texto'] }}</p>
        <p class="justify"><b>{{$paginaSobre['projeto_sensores_solucao_titulo']}}</b>{{ $paginaSobre['projeto_sensores_solucao_texto'] }}</p>
    </div>

    <div class="sobre_conjunto">
        <h5 class="bold">{{ $paginaSobre['projeto_objetivos'] }}</h5>
        <ul class="sobre_lista_objetivos">
            <li><b>{{$paginaSobre['projeto_objetivo_1_titulo']}}</b>{{ $paginaSobre['projeto_objetivo_1_texto'] }}</li>
            <li><b>{{$paginaSobre['projeto_objetivo_2_titulo']}}</b>{{ $paginaSobre['projeto_objetivo_2_texto'] }}</li>
            <li><b>{{$paginaSobre['projeto_objetivo_3_titulo']}}</b>{{ $paginaSobre['projeto_objetivo_3_texto'] }}</li>
        </ul>
    </div>

    <div class="sobre_conjunto">
        <h5 class="bold">{{ $paginaSobre['projeto_imagens_titulo'] }}</h5>
        <div class="sobre_imagens">
            @foreach ($paginaSobre['projeto_imagens'] as $key => $image)    
                <img class="sobre_imagem" src="{{ asset('images/projeto/' . $image) }}" alt="{{'Imagem do Projeto' . $key}}">
            @endforeach
        </div>
    </div>
</div>
