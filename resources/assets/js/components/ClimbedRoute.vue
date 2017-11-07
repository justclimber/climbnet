<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left">
                <v-ons-back-button>To climbs</v-ons-back-button>
            </div>
            <div class="center">Add a climbed route</div>
        </v-ons-toolbar>
        <v-ons-list>
            <v-ons-list-item>
                <v-ons-input
                    float
                    placeholder="Input name of route"
                    v-model="name"
                ></v-ons-input>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-select v-model="category_dict">
                    <option v-for="category, index in settings.dicts.categories" :value="index">
                        {{ category }}
                    </option>
                </v-ons-select>
                <v-ons-list-header>
                    Official route category
                </v-ons-list-header>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-select v-model="proposed_category_dict">
                    <option v-for="category, index in settings.dicts.categories" :value="index">
                        {{ category }}
                    </option>
                </v-ons-select>
                <v-ons-list-header>
                    Route category (your opinion)
                </v-ons-list-header>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-select v-model="route_type_dict">
                    <option v-for="route_type, index in settings.dicts.route_types" :value="index">
                        {{ route_type }}
                    </option>
                </v-ons-select>
                <v-ons-list-header>
                    Route type
                </v-ons-list-header>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-button @click="saveRoute">Save route</v-ons-button>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-button @click="saveAndAddNewRoute">Save and add another one</v-ons-button>
            </v-ons-list-item>
        </v-ons-list>
    </v-ons-page>
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
                name: '',
                category_dict: '',
                proposed_category_dict: '',
                route_type_dict: '',
            }
        },
        computed: mapState(['settings']),
        methods: {
            saveRoute() {
                axios.post('/api/climbed-routes', {
                    name: this.name,
                    category_dict: this.category_dict,
                    proposed_category_dict: this.proposed_category_dict,
                    climb_session_id: this.$route.params.id
                }).then(data => {
                    this.$router.push({name: 'climb', params: {
                        id: this.$route.params.id
                    }});
                    this.clear();
                });
            },
            saveAndAddNewRoute() {
                axios.post('/api/climbed-routes', {
                    name: this.name,
                    category_dict: this.category_dict,
                    proposed_category_dict: this.proposed_category_dict,
                    route_type_dict: this.route_type_dict,
                    climb_session_id: this.$route.params.id
                }).then(data => {
                    this.clear();
                })
            },
            clear() {
                this.name = '';
                this.category_dict = '';
                this.proposed_category_dict = '';
                this.route_type_dict = '';
            }
        },
    }
</script>
<style lang="scss">
    ons-list-item {
        ons-input {
            width:100%;
        }
    }
</style>
