<template>
    <div>
        <md-toolbar>
            <div class="left">
                <h3 class="md-title">Add a climb</h3>
            </div>
        </md-toolbar>
        <md-list>
            <md-list-item>
                <md-field>
                    <label>Input name or place of climb there</label>
                    <md-input v-model="name"></md-input>
                </md-field>
            </md-list-item>
            <md-list-item>
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
            </md-list-item>
            <md-list-item>
                <div>
                    Climbed routes in this session
                </div>
            </md-list-item>
            <md-list-item>
                <md-list>
                    <md-list-item class="climbed-route-row" v-for="climbedRoute in climbedRoutes" :key="climbedRoute.id">
                        <router-link :to="{ name: 'route-save', params: {route_id: climbedRoute.id}}">
                            {{ climbedRoute.name }} {{ category(climbedRoute.category_dict) }} ({{ category(climbedRoute.proposed_category_dict) }})
                        </router-link>
                    </md-list-item>
                </md-list>
            </md-list-item>
            <md-list-item>
                <a class="md-raised" @click="goToNewRoute">Add Route</a>
                <a class="md-raised" @click="updateClimb">Save your climb session</a>
            </md-list-item>
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
                api.getById('climbs', id).then(response => {
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
                let climbSessionData = {
                    id: this.id,
                    name: this.name,
                    date: this.datetime
                };
                api.save('climbs', climbSessionData).then(response => {
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
</style>
