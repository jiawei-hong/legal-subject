<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>法律常識</title>
        <link rel="stylesheet" href="/legal_subject/css/app.css">
    </head>

    <body>
        <div id="app">
            <navbar></navbar>

            <div class="container mt-2">
                <router-view></router-view>
            </div>
        </div>

        <script src="/legal_subject/js/app.js"></script>
    </body>

</html>
