<template>
    <v-app>
        <v-toolbar>
            <v-toolbar-title>Add a climbed route</v-toolbar-title>
        </v-toolbar>
        <v-container>
            <v-form>
                <v-text-field label="name of route" v-model="route.name"></v-text-field>
                <v-layout row wrap>
                    <v-flex xs6>
                        <climb-category label="Route category" v-model="route.category_dict"></climb-category>
                    </v-flex>
                    <v-flex xs6>
                        <climb-category label="Proposed?" v-model="route.proposed_category_dict"></climb-category>
                    </v-flex>
                </v-layout>
                <route-type label="Route type" v-model="route.route_type_dict"></route-type>
                <v-btn color="primary" @click="saveRoute">Save</v-btn>
                <v-btn color="accent" @click="saveAndAddNewRoute">Save and add another</v-btn>
            </v-form>
        </v-container>
    </v-app>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        components: {
            'climb-category': require('../components/ClimbCategory'),
            'route-type': require('../components/RouteType'),
        },
        data() {
            return {
                route: {
                    name: '',
                    category_dict: '',
                    proposed_category_dict: '',
                    route_type_dict: '',
                },
            }
        },
        computed: mapState(['settings']),
        methods: {
            saveRoute() {
                api.save('climbed-routes', this.route).then(data => {
                    this.clear();
                    this.$router.push({name: 'climb', params: {
                        id: this.$route.params.id
                    }});
                });
            },
            saveAndAddNewRoute() {
                api.save('climbed-routes', this.route).then(data => {
                    this.clear();
                })
            },
            loadClimbedRoute() {
                api.getById('climbed-routes', this.$route.params.route_id).then(response => {
                    this.route = response.data.data;
                    this.route.id = this.$route.params.route_id;
                });
            },
            clear() {
                this.route.name = '';
                this.route.category_dict = '';
                this.route.proposed_category_dict = '';
                this.route.route_type_dict = '';
            }
        },
        mounted() {
            if (this.$route.params.route_id) {
                this.loadClimbedRoute();
            }
            this.route.climb_session_id = this.$route.params.id;
        }
    }
</script>
<style lang="scss">
</style>
