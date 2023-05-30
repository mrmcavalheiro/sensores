<div class="slider">
    <ul class="slides">
        <li>
            <img src="{{ asset('images/banner/banner-slide-1.jpg') }}" alt="[imagme]" title={{ config('app.name') }}>
            <div class="caption left-align">
                <h3>Lorem 1: Sint, quisquam quo tempora laborum optio deleniti dicta non, maxime autem tempore reprehenderit unde nostrum ipsum! Quibusdam fugiat ab modi harum nostrum.</h3>
                <h5>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore amet ratione officia sit fuga sint in iste ipsum, quas vitae ipsa, hic exercitationem ipsam corrupti ex praesentium, facere sunt accusamus.</h5>
            </div>
        </li>
        <li>
            <img src="{{ asset('images/banner/banner-slide-2.jpg') }}" alt="[imagme]"
             title={{ config('app.name') }}>
            <div class="caption right-align">
                <h3>Lorem 2: Sint, quisquam quo tempora laborum optio deleniti dicta non, maxime autem tempore reprehenderit unde nostrum ipsum! Quibusdam fugiat ab modi harum nostrum.</h3>
                <h5>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore amet ratione officia sit fuga sint in iste ipsum, quas vitae ipsa, hic exercitationem ipsam corrupti ex praesentium, facere sunt accusamus.</h5>

            </div>
        </li>
        <li>
            <img src="{{ asset('images/banner/banner-slide-3.jpg') }}" alt="[imagme]" title={{ config('app.name') }}>
            <div class="caption right-align">
                <h3>Lorem 3: Sint, quisquam quo tempora laborum optio deleniti dicta non, maxime autem tempore reprehenderit unde nostrum ipsum! Quibusdam fugiat ab modi harum nostrum.</h3>
                <h5>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore amet ratione officia sit fuga sint in iste ipsum, quas vitae ipsa, hic exercitationem ipsam corrupti ex praesentium, facere sunt accusamus.</h5>
            </div>
        </li>
    </ul>
</div>

  {{-- banner-modal 1 --}}
  @include('partials.banner-modal')
