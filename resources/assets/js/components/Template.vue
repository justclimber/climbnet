<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left">
                <v-ons-back-button>Back</v-ons-back-button>
            </div>
            <div class="center">{{$options.name}}</div>
        </v-ons-toolbar>

        <br>
        <div class="links">
            <router-link :to="{name: 'climbs'}">Child-1</router-link>
            <router-link :to="{name: 'climb-save'}">Child-2</router-link>
        </div>
    </v-ons-page>
</template>

<script>
    export default {
        name: 'TemplatePage'
    }
</script>

<style>
    .links {
        margin: 20px;
    }
    .links li {
        margin: 10px 0;
    }
</style>