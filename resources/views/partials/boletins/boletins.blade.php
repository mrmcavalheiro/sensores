<div class="container boletins-container">
    <h5 class="bold">{{ $boletins['tituloPagina'] }}</h5>

    <div class="boletins_wrapper">
        @foreach ($boletins['boletins'] as $boletim)
            <div class="boletim_wrapper">
                <a href="{{ asset('files/' .$boletim['file']) }}" target="_blank">
                    <i class="fa-solid fa-file-arrow-down download_button"></i>
                </a>
                <span>{{ $boletim['nome'] }}</span>
            </div>
        @endforeach
    </div>
</div>