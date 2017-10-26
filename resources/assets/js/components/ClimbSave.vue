<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left">
                <v-ons-back-button>To climbs</v-ons-back-button>
            </div>
            <div class="center">Add a climb</div>
        </v-ons-toolbar>
    </v-ons-page>
</template>

<script>
    export default {
        data() {
            return {
                climbs: []
            }
        },
        methods: {
        },
        mounted() {
            axios.get('/climbs')
                .then(response => this.climbs = response.data.data);
        }
    }
</script>
