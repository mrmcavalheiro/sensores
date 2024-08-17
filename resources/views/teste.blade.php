<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .carousel-item img {
            width: 100%;
            height: 600px; /* Ajuste para a altura desejada */
            object-fit: cover;
        }
    </style>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <!-- Example Code -->
          
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="4000">
          <img src="{{ asset('images/banner/banner-slide-1.jpg') }}" class="d-block w-100" alt="imagem" title="{{ config('app.name') }}">
          <div class="carousel-caption d-none d-md-block">
            <h3>"A agricultura é a arte de alimentar, nutrir e cultivar o mundo."</h3>
            <h5>- Unknown</h5>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="4000">
          <img src="{{ asset('images/banner/banner-slide-2.jpg') }}" class="d-block w-100" alt="imagem" title="{{ config('app.name') }}">
          <div class="carousel-caption d-none d-md-block">
            <h3>"A agricultura é o meio mais saudável, mais útil e mais nobre para se ganhar a vida."</h3>
            <h5>- George Washington</h5>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="4000">
          <img src="{{ asset('images/banner/banner-slide-3.jpg') }}" class="d-block w-100" alt="imagem" title="{{ config('app.name') }}">
          <div class="carousel-caption d-none d-md-block">
            <h3>"A inovação é a chave para o sucesso na agricultura moderna."</h3>
            <h5>- Norman Borlaug</h5>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
      </button>
    </div>     
    <!-- End Example Code -->
  </body>
</html>
