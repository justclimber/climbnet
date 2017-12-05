<template>
    <v-app>
        <v-toolbar>
            <v-toolbar-title>My climbs</v-toolbar-title>
        </v-toolbar>
        <v-container>
            <v-form>
                <v-text-field label="name or place of climb" v-model="name"></v-text-field>
                <v-dialog
                    persistent
                    v-model="dateModal"
                    lazy
                    full-width
                    width="290px"
                >
                    <v-text-field
                        slot="activator"
                        label="Date and time of climb"
                        v-model="datetime"
                        append-icon="event"
                        readonly
                    ></v-text-field>
                    <v-date-picker
                        v-model="date"
                        scrollable
                        actions
                        v-show="!timeModal"
                        :first-day-of-wee="1"
                    >
                        <template slot-scope="{ save }">
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="timeModal = true">OK</v-btn>
                            </v-card-actions>
                        </template>
                    </v-date-picker>
                    <v-time-picker
                        v-model="time"
                        actions
                        v-show="timeModal"
                        format="24hr"
                    >
                        <template slot-scope="{ save }">
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="save">Ok</v-btn>
                            </v-card-actions>
                        </template>
                    </v-time-picker>
                </v-dialog>
                <div>
                    Climbed routes in this session
                </div>
                <v-list>
                    <climbed-route-row
                        v-for="climbedRoute in climbedRoutes"
                        :key="climbedRoute.id"
                        :climbedRoute="climbedRoute"
                    ></climbed-route-row>
                </v-list>
                <v-btn @click="goToNewRoute">Add Route</v-btn>
                <v-btn @click="updateClimb">Save climb session</v-btn>
            </v-form>
        </v-container>
    </v-app>
</template>

<script>
    import format from 'date-fns/format';
    import parse from 'date-fns/parse';

    export default {
        components: {
            'climbed-route-row': require('../components/ClimbedRouteRow')
        },
        data() {
            let now = new Date;
            return {
                dateModal: false,
                timeModal: false,
                name: '',
                date: format(now, 'YYYY-MM-DD'),
                time: format(now, 'HH:mm'),
                climbedRoutes: []
            }
        },
        computed: {
            datetime() {
                return this.date + ' ' + this.time;
            }
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
            loadClimb(id) {
                api.getById('climbs', id).then(response => {
                    let responseClimb = response.data.data;
                    let date = parse(responseClimb.date);

                    this.name = responseClimb.name;
                    this.date = format(date, 'YYYY-MM-DD');
                    this.time = format(date, 'HH:mm');
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
</style>
