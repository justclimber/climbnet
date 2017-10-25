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
        <template id="main">
            <v-ons-navigator swipeable
                             :page-stack="pageStack"
                             v-on:push-page="pageStack.push($event)"
            ></v-ons-navigator>
        </template>

        <template id="page1">
            <v-ons-page>
                <v-ons-toolbar>
                    <div class="center">Страничка намбер уан</div>
                </v-ons-toolbar>
                <p style="text-align: center">
                    Тут можено перейти
                    <v-ons-button v-on:click="push">На другую страничку</v-ons-button>
                </p>
            </v-ons-page>
        </template>

        <template id="page2">
            <v-ons-page>
                <v-ons-toolbar>
                    <div class="left">
                        <v-ons-back-button>Страничка намбер уан</v-ons-back-button>
                    </div>
                    <div class="center">Другая страничка</div>
                </v-ons-toolbar>
                <p style="text-align: center">А это страничка специально для Людочки! ;-*</p>
            </v-ons-page>
        </template>

        <div id="app"></div>

        <script src="js/app.js"></script>
    </body>
</html>
