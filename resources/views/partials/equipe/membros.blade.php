<div class="row container">
    @foreach (\App\Models\SistemaGlobal::$paginaEquipe[0]['membros'] as $membro)
        <div class="col s12 m6 l4 center-align hoverable">
            <div class="container">
                <div class="col s12 center-align mt-2">
                    <img src="{{ asset('images/equipe/membros/' . $membro['foto']) }}" alt="{{ $membro['nome'] }}"
                        title="{{ config('app.name') }}" class="responsive-img circle materialboxed">
                </div>
            </div>
            <div class="container">
                <p class="flow-text">{{ $membro['nome'] }}</p>
                <div class="descricao-container">
                    <p class="descricao">{{ $membro['descricao'] }}</p>
                </div>
                <p>
                    <a href="{{ $membro['contato_email'] }}"><i class="small fa-solid fa-envelope"></i></a>
                    <a href="{{ $membro['facebook'] }}"><i class="small fa-brands fa-facebook"></i></a>
                    <a href="{{ $membro['instagram'] }}"><i class="small fa-brands fa-instagram"></i></a>
                </p>
            </div>
        </div>
    @endforeach
</div>


