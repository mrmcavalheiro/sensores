<div class="row container">
    @foreach ($apoiadores as $index => $apoiador)
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    @if ($index % 2 == 0)
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <span class="card-title flow-text blue-text"><b>{{ $apoiador['nome'] }}</b></span>
                                <p class="flow-text justify black-text">
                                    <textarea readonly class="flow-text justify black-text descricao-textarea">
                                        {{ $apoiador['descricao'] }}
                                    </textarea>
                                </p>
                            </div>
                            <div class="col s12 m6 l6 ">
                                <div class="card-image ">
                                    <img src="{{ asset('images/parceiros/patrocinadores/' . $apoiador['logo']) }}" alt="{{ $apoiador['nome'] }}">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <div class="container img-direita">
                                    <div class="card-image ">
                                        <img src="{{ asset('images/parceiros/patrocinadores/' . $apoiador['logo']) }}" alt="{{ $apoiador['nome'] }}"
                                            title="{{ config('app.name') }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m6 l6">
                                <span class="card-title flow-text blue-text"><b>{{ $apoiador['nome'] }}</b></span>
                                <p class="flow-text justify black-text">
                                    <textarea readonly class="flow-text justify black-text descricao-textarea">
                                        {{ $apoiador['descricao'] }}
                                    </textarea>
                                </p>
                            </div>
                        </div>

                    @endif
                </div>
                <div class="card-action">
                    <a href="{{ $apoiador['website'] }}" target="_blank">Visitar Site</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
