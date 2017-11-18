<template>
    <div>
        <md-toolbar>
            <div class="left">
                <h3 class="md-title">Add a climbed route</h3>
            </div>
        </md-toolbar>
        <md-list class="route-list">
            <md-field>
                <label>Input name of route</label>
                <md-input v-model="route.name"></md-input>
            </md-field>
            <md-field>
                <label for="category">Official route category</label>
                <md-select v-model="route.category_dict" id="category">
                    <md-option v-for="category, index in settings.dicts.categories" :value="index" :key="index">
                        {{ category }}
                    </md-option>
                </md-select>
            </md-field>
            <md-field>
                <label for="category_proposed">Your opinion</label>
                <md-select v-model="route.proposed_category_dict" id="category_proposed">
                    <md-option v-for="category, index in settings.dicts.categories" :value="index" :key="index">
                        {{ category }}
                    </md-option>
                </md-select>
            </md-field>
            <md-field>
                <label for="route_type">Route type</label>
                <md-select v-model="route.route_type_dict" id="route_type">
                    <md-option v-for="route_type, index in settings.dicts.route_types" :value="index"  :key="index">
                        {{ route_type }}
                    </md-option>
                </md-select>
            </md-field>
            <div>
                <a @click="saveRoute">Save route</a>
                <a @click="saveAndAddNewRoute">Save and add another one</a>
            </div>
        </md-list>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Datepicker from 'vuejs-datepicker';
    import VueTimepicker from 'vue2-timepicker'
    import moment from 'moment';
    import { mapState } from 'vuex';

    Vue.component('datepicker', Datepicker);
    Vue.component('timepicker', VueTimepicker);

    export default {
        data() {
            return {
                route: {
                    name: '',
                    category_dict: '',
                    proposed_category_dict: '',
                    route_type_dict: '',
                }
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
    .md-list.route-list {
        padding: 1rem;
    }
</style>
