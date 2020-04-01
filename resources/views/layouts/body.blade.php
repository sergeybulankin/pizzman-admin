<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(Auth::check())
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endif()

    <title>Pizzman and Kalachev | Admin Panel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href={{ asset('css/style.css') }} type="text/css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
           'role' => $role_id,
           'apiToken' => Auth::user()->api_token ?? null,
        ]) !!};
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <!--<script src={{ asset('js/dropzone.js') }} type="text/javascript"></script>-->
</head>

<body>
<div id="app" class="wrap">

    <div class="mobile-block">
        <nav class="navbar navbar-expand-lg nav-gray">
            <button type="button" data-toggle="modal" data-target="#menu-mobil" class="navbar-toggler">
                <span class="navbar-toggler-icon fa fa fa-bars"></span>
            </button>
        </nav>

        @include('layouts.mobile')
    </div>

    <div class="left-block">
        @include('components.roles.roles')
        @yield('crud')
    </div>

    <div class="right-block">
        @yield('user')
        @yield('content')
        @yield('calls')
    </div>
</div>
</body>
<script src={{ asset('js/app.js') }} type="text/javascript"></script>
<script>
    // upload preview image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#onload-image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });
</script>
<script>
    $(document).ready(function(){
        $('.alert-success, .alert-danger').fadeIn().delay(3000).fadeOut();
    });
</script>
</html>