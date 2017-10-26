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
        <v-ons-fab ripple position="bottom right">
            <v-ons-icon icon="md-plus" @click="addClimb()"></v-ons-icon>
        </v-ons-fab>
    </v-ons-page>
</template>

<script>
    import ClimbSave from './ClimbSave.vue';
    export default {
        data() {
            return {
                climbs: []
            }
        },
        methods: {
            addClimb() {
                this.$emit('push-page', ClimbSave);
            }
        },
        mounted() {
            axios.get('/climbs')
                .then(response => this.climbs = response.data.data);
        }
    }
</script>
