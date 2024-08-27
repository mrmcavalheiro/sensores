<div class="contato_formulario">
    <form action="{{ route('novocontato') }}" method="post">
        @csrf
        <div class="input-field">
            <i class="fa-solid fa-user prefix"></i>
            <input type="text" name="name" id="name" required>
            <Label for="name">Seu Nome</Label>
        </div>

        <div class="input-field">
            <i class="fa-solid fa-at prefix"></i>
            <input type="email" name="email" id="email" required>
            <label for="email">Seu e-mail</label>
        </div>

        <div class="input-field">
            <i class="fa-solid fa-envelope-open-text  prefix"></i>
            <textarea id="textarea1" name="message" class="materialize-textarea textarea-field"></textarea>
            <label for="textarea1">Mensagem</label>
        </div>

        <div>
            <button type="submit" class="btn-small blue"><i class="fa-regular fa-paper-plane left"></i>Enviar</button>
            <button type="reset" class="btn-small indigo"><i class="fa-solid fa-eraser left"></i>Limpar</button>
        </div>
    </form>
</div>

{{-- <div class="divider"></div>
<div class="row continer">
    <div class="col s12  m6 push-l3">
        <h1 class="flow-text"><b>Mensagem:</b></h1>
        <p class="paragrafo">
            Sua opinião é importante para nós, abaixo podes enviar uma mensagem.<br>
            Assim que possível entraremos em contato.
        </p>
    </div>
    <div class="col s12">
        <form action="{{ route('novocontato') }}" method="post">
            @csrf
            <div class="row">
                
                <div class="col s12 m5 input-field">
                    <i class="fa-solid fa-user prefix"></i>
                    <input type="text" name="name" id="name" required>
                    <Label for="name">Seu Nome</Label>
                </div>

                
                <div class="col s12 m5 input-field">
                    <i class="fa-solid fa-at prefix"></i>
                    <input type="email" name="email" id="email" required>
                    <label for="email">Seu e-mail</label>
                </div>

                
                <div class="col s12 input-field">
                    <i class="fa-solid fa-envelope-open-text  prefix"></i>
                    <textarea id="textarea1" name="message"  class="materialize-textarea"></textarea>
                    <label for="textarea1">Mensagem</label>
                </div>

                
                <div class="col s12 input-field">
                    <button type="submit" class="btn-small blue"><i class="fa-regular fa-paper-plane left"></i>Enviar</button>
                    <button type="reset" class="btn-small indigo"><i class="fa-solid fa-eraser left"></i>Limpar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="divider"></div> --}}
