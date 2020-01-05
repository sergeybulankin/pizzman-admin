<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pizzman and Kalachev | Admin Panel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href={{ asset('css/style.css') }} type="text/css" rel="stylesheet">

    <!-- Scripts -->
    <script src={{ asset('js/app.js') }} type="text/javascript"></script>
</head>

<body>
<div class="columns columns-is-dark">
    <div class="auth auth-is-dark">
        @if (Auth::guest())
            <div class="auth-wrap">
                <div class="logo">
                    <img src="images/logo.png" alt="">
                </div>

                <div class="auth-title">
                    <span class="auth-title-subtitle">Готовим как себе!</span>
                </div>

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input id="name" type="name" class="input-auth" placeholder="Номер телефона" name="name" value="{{ old('name') }}" required autofocus><br /><br />

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input id="password" type="password" placeholder="Пароль" class="input-auth" name="password" required><br /><br />

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox remember">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="button-auth">
                                Войти
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="auth-wrap">
                <div class="logo">
                    <img src="images/logo.png" alt="">
                </div>

                <div class="auth-title">
                    <span class="auth-title-subtitle">Вы уже в системе</span>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="/dashboard" class="href-auth">
                            Войти
                        </a>
                    </div>
                </div>
            </div>
        @endif()
    </div>
    <div class="image image-is-auth"></div>
</div>
</body>
</html>