<div class="modal" id="modal-lead">
    <div class="modal-content">
        <h3 class="flow-text">Preencha todos os dados solicitados</h3>
        <form action="{{ route('lead') }}" method="post">
            @csrf
            <div class="row">
                {{-- Cadastro do Nome --}}
                <div class="col s12 m6 input-field">
                    <i class="material-icons prefix">person</i>
                    <input type="text" name="name" id="name" required>
                    <label for="name">Digite seu Nome:</label>
                </div>
                {{-- Cadastro do Telefone --}}
                <div class="col s12 m6 input-field">
                    <i class="material-icons prefix">phone_iphone</i>
                    <input type="tel" name="tel" id="tel" required>
                    <label for="tel">Digite seu número de telefone:</label>
                </div>
                {{-- Cadastro do Email --}}
                <div class="col s12 input-field">
                    <i class="material-icons prefix">email</i>
                    <input type="email" name="email" id="email" required>
                    <label for="email">Digite seu E-mail:</label>
                </div>
                {{-- botões de ação
                <div class="col s12 m6 input-field">
                    <input type="submit" value="Enviar" class="btn btn-small blue">
                    <input type="reset" value="Limpar" class="btn btn-small red">
                </div>--}}
            </div>
        </form>
    </div>
</div>
