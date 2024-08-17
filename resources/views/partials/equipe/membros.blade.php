
<div class="equipe-container">
    @foreach (\App\Models\SistemaGlobal::$paginaEquipe[0]['membros'] as $membro)    
        <div class="membro-card">
            <img src="{{ asset('images/equipe/membros/' . $membro['foto']) }}" alt="{{ $membro['nome'] }}">
            <h3>{{ $membro['nome'] }}</h3>
            <p>{{ $membro['descricao'] }}</p>
            <div class="social-links">
                @if(isset($membro['email']))
                    <a href="mailto:{{ $membro['email'] }}"><i class="fa fa-envelope"></i></a>
                @endif
                @if(isset($membro['twitter']))
                    <a href="{{ $membro['twitter'] }}"><i class="fa fa-twitter"></i></a>
                @endif
                @if(isset($membro['facebook']))
                    <a href="{{ $membro['facebook'] }}"><i class="fa fa-facebook"></i></a>
                @endif
                @if(isset($membro['instagram']))
                    <a href="{{ $membro['instagram'] }}"><i class="fa fa-instagram"></i></a>
                @endif
                @if(isset($membro['lattes']))
                    <div class="lattes-link">
                        <a href="{{ $membro['lattes'] }}" target="_blank"><i>Lattes</i></a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>