<div class="account">
    <h3>Привет, {{ $account->account->name }}!</h3>

    <div class="list-group">
        @if($role_id == 4)
            <nav class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="/control">Управление</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/calls">Звонки <span class="count-calls">{{ $count_calls }}</span></a>
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
        @elseif($role_id == 3)
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