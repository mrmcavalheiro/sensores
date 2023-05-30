<x-mail::message>
    <h1>Novas informações de contato</h1>

    Prezado(a) {{ env('MAIL_FROM_RESPONSAVEL') }},

    É com prazer que informamos que você tem um novo contato.
    Abaixo estão os detalhes do contato:
      -Nome: {{ $dadosEmail['name'] }}
      -Telefone: {{ $dadosEmail['tel'] }}
      -Email: {{ $dadosEmail['email'] }}

    Você pode acessar nosso site clicando no link abaixo:
   <x-mail::button :url="config('app.url')">
    Acesse o seu site clicando aqui
</x-mail::button>

    Agradecemos pelo seu contínuo apoio.

    Atenciosamente,
    {{ date('d/m/Y') }}
    {{ config('app.name') }}
    Link:{{ config('app.url') }}
</x-mail::message>
