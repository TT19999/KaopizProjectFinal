<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">PBLOG</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="/">Home</a>
                    </li>


                    @auth()
                        <li class="nav-item">
                            <a class="nav-link" href="/Create">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Create">Kho Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/a">a</a>
                        </li>
                        <li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{\Illuminate\Support\Facades\Auth::user()->name}}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="/user/profile">
                                        <button class="dropdown-item" type="button">profile</button>
                                    </a>

                                    <a href="/logout">
                                        <button class="dropdown-item" type="button">logout</button>
                                    </a>

                                    <button class="dropdown-item" type="button">Something else here</button>
                                </div>
                            </div>
                        </li>
                    @endauth
                    @guest()
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

</header>
