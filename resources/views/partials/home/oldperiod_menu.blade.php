<div class="card">
    <div class="card-content">
        <span class="card-title teal-text text-darken-4 bold card-title"><h3>-Selecione o período:</h3></span>
        <div class="button-group center-align">
            @foreach($periods as $period)
                <button class="btn-large teal darken-1 white-text">{{ $period }}</button>
            @endforeach
        </div>
    </div>
</div>
