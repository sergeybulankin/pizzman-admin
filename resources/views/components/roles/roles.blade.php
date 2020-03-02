<div class="logo">
    Logo
</div>

<div class="account">
    <div class="list-group">
        @if($role_id == 4)
            <nav class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link" href="/dashboard">
                                <img src="../images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                Заказы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/control">
                                <img src="../images/icons/administration.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                Управление
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/calls">
                                <img src="../images/icons/telephone.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                Звонки <span class="count-calls">{{ $count_calls }}</span>
                            </a>
                        </li>
                        <li class="nav-item logout">
                            <a class="nav-link" href="/logout">
                                <img src="../images/icons/logout.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                выход
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        @elseif($role_id == 3)
            <nav class="navbar navbar-expand-lg">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link" href="/dashboard">
                                <img src="../images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                Заказы
                            </a>
                        </li>
                        <li class="nav-item logout">
                            <a class="nav-link" href="/logout">
                                <img src="../images/icons/logout.png" width="24" height="24" class="d-inline-block align-top" alt="">
                                выход
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        @endif()
    </div>
</div>