<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="flow-text">@yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <!--Import fontawesome Icons-->
    <script src="https://kit.fontawesome.com/7ad49d8e22.js" crossorigin="anonymous"></script>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- css do Materialize --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

</head>
<body>
    {{-- navbar --}}
    @include('partials.navbar')

    {{-- banner-slide.blade --}}
    @include('partials.banner-slide')

    {{-- conteúdo principal --}}
    @yield('content')

    {{-- footer.blade --}}
    @include('partials.footer')

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>


    {{-- js do Materialize --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $('.collapsible').collapsible();
    </script>

</body>
</html>
