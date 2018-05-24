<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token()}}"> 
        <title>Developer App Panel</title>
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center">
                    <h1 class="panel-title">Developer Webpage Admin</h1>
                </div>
            <div id="app">
                <ul class="nav nav-pills" style="padding:15px;">
                    <li class="nav-item">
                        <router-link class="nav-link" tag="a" to="/" exact>
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" tag="a" to="/variables/index">
                            Variables
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" tag="a" to="/portfolios/index">
                            Portfolios
                        </router-link>
                    </li>
                </ul>
                {{-- Content View --}}
                <router-view></router-view>
            </div>
            </div>
        </div>
        </div>
    <script src="/js/app.js"></script>
    </body>
</html>
