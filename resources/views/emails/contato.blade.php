<x-mail::message>
<h1> Mensagem do {{ $dadosEmail['name'] }}</h1>
    <x-mail::panel>
        Favor entrar em contato para verificar do que se trata.<br>
        Desde já agradeçemos por vossa dedicação e atenção ao projeto.<br>
        Att.<br>

        Coordenção do projeto!
        {{ config('app.name') }}
    </x-mail::panel>

Abaixo estão os detalhes do contato: <br>
    -Nome: {{ $dadosEmail['name'] }} <br>
    -Email: {{ $dadosEmail['email'] }} <br>
    -Mensagem: <br>
        {{ $dadosEmail['message'] }}
    <x-mail::button :url="config('app.url')">
         Acesse o seu site clicando aqui
    </x-mail::button>

Atenciosamente,<br>

{{ date('d/m/Y') }}
{{ config('app.name') }}
Link:{{ config('app.url') }}
</x-mail::message>
