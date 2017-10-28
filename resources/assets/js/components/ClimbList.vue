<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="center">My climbs</div>
        </v-ons-toolbar>
        <v-ons-list>
            <v-ons-list-item v-for="climb in climbs" :key="climb.id">
                {{ climb.date }}: {{ climb.name }}
            </v-ons-list-item>
        </v-ons-list>
        <router-link :to="{name: 'climb-save'}">
            <v-ons-fab ripple position="bottom right">
                <v-ons-icon icon="md-plus"></v-ons-icon>
            </v-ons-fab>
        </router-link>
    </v-ons-page>
</template>

<script>
    export default {
        data() {
            return {
                climbs: []
            }
        },
        mounted() {
            axios.get('/climbs')
                .then(response => this.climbs = response.data.data);
        }
    }
</script>
