<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pizzman and Kalachev | Admin Panel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href={{ asset('css/style.css') }} type="text/css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</head>

<body>
    <div id="app">
        <div class="account">
            <h3>Привет, {{ $account->account->name }}!</h3>

            <div class="list-group">
                @if($role->role->id == 4)
                    <nav class="navbar navbar-expand-lg">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="/control">Управление</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">пункт</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">пункт</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">выход</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @elseif($role->role->id == 2)
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">пункт</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">выход</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                @endif()
            </div>
        </div>

        <board></board>
    </div>
</body>
    <script src={{ asset('js/app.js') }} type="text/javascript"></script>
</html>