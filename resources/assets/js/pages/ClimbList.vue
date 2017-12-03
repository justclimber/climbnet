<template>
    <v-app>
        <v-toolbar>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-btn
                fab
                small
                bottom
                right
                absolute
                v-can:create="'Climb'"
                @click="newClimbDialogVisible = true"
            >
                <v-icon>add</v-icon>
            </v-btn>
            <v-toolbar-title>My climbs</v-toolbar-title>
        </v-toolbar>
        <v-dialog v-model="newClimbDialogVisible" max-width="500px">
            <v-card>
                <v-card-text>
                    <v-text-field
                        label="name or place of climb"
                        v-model="newClimb.name"
                    ></v-text-field>
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
                            v-model="newClimb.date"
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
                            v-model="newClimb.time"
                            actions
                            v-show="timeModal"
                            format="24hr"
                        >
                            <template slot-scope="{ save }">
                                <v-card-actions>
                                    <v-btn flat color="primary" @click="save">Ok</v-btn>
                                </v-card-actions>
                            </template>
                        </v-time-picker>
                    </v-dialog>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="addClimb">Add</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-list>
            <climb-session-row v-for="climb in climbs" :key="climb.id" :climb="climb"></climb-session-row>
        </v-list>
    </v-app>
</template>

<script>
    var format = require('date-fns/format');
    export default {
        components: {
            'climb-session-row': require('../components/ClimbSessionRow')
        },
        data() {
            let now = new Date;
            return {
                climbs: [],
                newClimbDialogVisible: false,
                dateModal: false,
                timeModal: false,
                newClimb: {
                    name: '',
                    date: format(now, 'YYYY-MM-DD'),
                    time: format(now, 'HH:mm'),
                }
            }
        },
        watch: {
            '$route': 'routeChanged'
        },
        computed: {
            datetime() {
                return this.newClimb.date + ' ' + this.newClimb.time;
            }
        },
        methods: {
            routeChanged(route) {
                if (route.name === 'climbs') {
                    this.loadClimbs();
                }
            },
            loadClimbs() {
                api.get('climbs')
                    .then(response => this.climbs = response.data.data);
            },
            addClimb() {
                api.save('climbs', {
                    name: this.newClimb.name,
                    date: this.datetime
                }).then(response => {
                    this.$router.push({name: 'climb', params: {
                        id: response.data.id
                    }});
                    this.newClimbDialogVisible = false;
                })
            },
        },
        mounted() {
            this.loadClimbs()
        }
    }
</script>
<style lang="scss">
</style>

