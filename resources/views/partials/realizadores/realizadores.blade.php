<div class="row container realizador_main_container">
    @foreach ($realizadores as $index => $apoiador)
        <div class="apoiador_container m0">
            <a href="{{ $apoiador['website'] }}" target="_blank">
                <img 
                    src="{{ asset('images/parceiros/parceiros/' . $apoiador['logo']) }}"
                    alt="{{ $apoiador['nome'] }}"
                    title="{{ config('app.name') }}" 
                    class="{{ $apoiador['imageOrientation'] }}">
            </a>
        </div>
    @endforeach
</div>
