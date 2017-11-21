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
                @click="newClimbDialogVisible = true"
            >
                <v-icon>add</v-icon>
            </v-btn>
            <v-toolbar-title>My climbs</v-toolbar-title>
        </v-toolbar>
        <v-dialog v-model="newClimbDialogVisible" max-width="500px">
            <v-card>
                <v-card-text>
                    <v-text-field label="File name"></v-text-field>
                    <small class="grey--text">* This doesn't actually save.</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="newClimbDialogVisible = false">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-list>
            <template v-for="climb in climbs">
                <v-subheader>
                    {{ climb.date }}:
                    <router-link :to="{ name: 'climb', params: {id: climb.id}}">{{ climb.name }}</router-link>
                </v-subheader>
            </template>
        </v-list>
        <!--<md-button-->
            <!--class="md-fab md-fab-bottom-right"-->
            <!--@click="newClimbDialogVisible = true"-->
            <!--v-can:create="'Climb'"-->
        <!--&gt;-->
            <!--<md-icon>add</md-icon>-->
        <!--</md-button>-->

        <!--<md-dialog-->
            <!--:md-active.sync="newClimbDialogVisible"-->
            <!--:md-fullscreen="false"-->
        <!--&gt;-->
            <!--<div class="climb-add">-->
                <!--<div class="row">-->
                    <!--<md-field>-->
                        <!--<label>Input name or place of climb there</label>-->
                        <!--<md-input v-model="newClimb.name"></md-input>-->
                    <!--</md-field>-->
                <!--</div>-->
                <!--<div class="row">-->
                    <!--<span class="input-name">When: </span>-->
                    <!--<datepicker-->
                        <!--:monday-first="true"-->
                        <!--:calendar-button="true"-->
                        <!--calendar-button-icon="fa fa-calendar"-->
                        <!--v-model="newClimb.date"-->
                        <!--:value="newClimb.date"-->
                    <!--&gt;</datepicker>-->
                    <!--<timepicker-->
                        <!--:minute-interval="5"-->
                        <!--v-model="newClimb.time"-->
                    <!--&gt;</timepicker>-->
                <!--</div>-->
                <!--<md-button class="md-primary md-raised" @click="addClimb">Add</md-button>-->
            <!--</div>-->
        <!--</md-dialog>-->
    </v-app>
</template>

<script>
    export default {
        data() {
            let now = new Date;
            return {
                climbs: [],
                newClimbDialogVisible: false,
                newClimb: {
                    name: '',
                    date: now,
                    time: {
                        HH: now.getHours(),
                        mm: now.getMinutes(),
                        ss: 0
                    },
                }
            }
        },
        watch: {
            '$route': 'routeChanged'
        },
        computed: {
            datetime() {
                let date = new Date(this.newClimb.date);
                return date.toISOString().substring(0, 10) + ' ' + this.newClimb.time.HH + ':' + this.newClimb.time.mm;
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
            }
        },
        mounted() {
            this.loadClimbs()
        }
    }
</script>
<style lang="scss">
    .md-dialog .climb-add {
        width: 19rem;
        height: 16rem;
        margin: 2rem 1rem 1rem 1rem;
        .row {
            padding-top: 1rem;
        }
        .vdp-datepicker input {
            font-size: 0.8em;
        }
        .time-picker input.display-time {
            border: none;
            font-size: 0.8em;
        }
        .vdp-datepicker__calendar {
            border: none;
            top: -6rem;
            width: 19rem;
        }
    }
</style>

