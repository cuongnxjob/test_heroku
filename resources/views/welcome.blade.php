<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('canvas-js-sdk/css/canvas.css') }}" />
        <script src="{{ asset('canvas-js-sdk/js/canvas-all.js') }}"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
        <script>
            if (self === top) {
                // Not in Iframe
                alert("This canvas app must be included within an iframe");
            }

            Sfdc.canvas.onReady(function () {
                console.log("Canvas application ready");
                Sfdc.canvas(function() {
                    // var sr = JSON.parse('<%=signedRequestJson%>');
                    var sr = JSON.parse('<%=signedRequestJson%>');
                    console.log(sr);
                    // Save the token
                    Sfdc.canvas.oauth.token(sr.oauthToken);
                    Sfdc.canvas.byId('username').innerHTML = sr.context.user.fullName;
                });
            });
        </script>

        <!-- init block -->
        <script>
            var client = {!! $client !!};
            console.log(client);
            // var signedRequest = JSON.parse(sr);
        </script>

        <!-- global var initialization block -->
        <script>
            var namespacePrefix = '';
            var vfTopic = 'vfTopic';
            var canvasTopic = 'canvasTopic';
        </script>

        <!-- publish block -->
        <script>
            {{--var clientData = {!! $client !!};--}}
            // var client = JSON.parse(clientData);
            function canvasPublish(message) {
                Sfdc.canvas.client.publish( client,{
                    name :  namespacePrefix  + canvasTopic,
                    payload : message
                });
                console.log(' canvas published : ' + message + ' to ' + canvasTopic );
            }
        </script>
    </body>
</html>
