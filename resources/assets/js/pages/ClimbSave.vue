<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left">
                <v-ons-back-button>To climbs</v-ons-back-button>
            </div>
            <div class="center">Add a climb</div>
        </v-ons-toolbar>
        <!--<v-ons-list>-->
            <v-ons-list-item>
                <v-ons-input
                    float
                    placeholder="Input name or place of climb there"
                    v-model="name"
                ></v-ons-input>
            </v-ons-list-item>
            <v-ons-list-item>
                <datepicker
                    :monday-first="true"
                    :calendar-button="true"
                    calendar-button-icon="fa fa-calendar"
                    v-model="date"
                    :value="date"
                ></datepicker>
                <timepicker
                    :minute-interval="5"
                    v-model="time"
                ></timepicker>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-list-header>
                    Climbed routes in this session
                </v-ons-list-header>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-list>
                    <v-ons-list-item class="climbed-route-row" v-for="climbedRoute in climbedRoutes" :key="climbedRoute.id">
                        <router-link :to="{ name: 'route-save', params: {route_id: climbedRoute.id}}">
                            {{ climbedRoute.name }} {{ category(climbedRoute.category_dict) }} ({{ category(climbedRoute.proposed_category_dict) }})
                        </router-link>
                    </v-ons-list-item>
                </v-ons-list>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-button @click="goToNewRoute">Add Route</v-ons-button>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-button @click="updateClimb">Save your climb session</v-ons-button>
            </v-ons-list-item>
        <!--</v-ons-list>-->
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
            let now = new Date;
            return {
                name: '',
                date: now,
                time: {
                    HH: now.getHours(),
                    mm: now.getMinutes(),
                    ss: 0
                },
                climbedRoutes: []
            }
        },
        computed: {
            ...mapState(['settings']),
            datetime() {
                let date = new Date(this.date);
                return date.toISOString().substring(0, 10) + ' ' + this.time.HH + ':' + this.time.mm;
            },
        },
        watch: {
            '$route': 'routeChanged'
        },
        methods: {
            routeChanged(route) {
                if (route.name === 'climb') {
                    this.loadClimb(this.id);
                }
            },
            category(category_dict) {
                return this.settings.dicts.categories[category_dict];
            },
            loadClimb(id) {
                axios.get('/api/climbs/' + id).then(response => {
                    let responseClimb = response.data.data;
                    let date = moment(responseClimb.date, 'DD.MM.Y HH:mm').toDate();

                    this.name = responseClimb.name;
                    this.date = date;
                    this.time = {
                        HH: date.getHours(),
                        mm: date.getMinutes(),
                        ss: 0,
                    };
                    this.climbedRoutes = responseClimb.climbedRoutes;
                })
            },
            updateClimb() {
                axios.put('/api/climbs/' + this.id, {
                    name: this.name,
                    date: this.datetime
                }).then(response => {
                    this.$router.push({name: 'climbs'});
                });
            },
            goToNewRoute() {
                this.$router.push({name: 'new-route', params: {climb_id: this.id}});
            }
        },
        mounted() {
            this.id = this.$route.params.id;
            this.loadClimb(this.id);
        }
    }
</script>
<style lang="scss">
    ons-list-item {
        ons-input {
            width:100%;
        }
        .vdp-datepicker input {
            font-size: 1em;
            width: 125px;
        }
        .time-picker input.display-time {
            border: none;
        }
    }
    .climbed-route-row {
    }
    /*.vdp-datepicker__calendar {*/
        /*position: fixed !important;*/
    /*}*/
</style>
