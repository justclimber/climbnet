<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/app.css">
        <title>Laravel</title>
    </head>
    <body>
        <div id="app">
            <v-ons-navigator swipeable
                             :page-stack="pages"
                             v-on:push-page="pages.push($event)"
            ></v-ons-navigator>
        </div>

        <script src="js/app.js"></script>
    </body>
</html>
