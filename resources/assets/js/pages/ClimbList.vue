<template>
    <div>
        <md-toolbar>
            <h3 class="md-title">My climbs</h3>
        </md-toolbar>
        <md-list>
            <md-list-item v-for="climb in climbs" :key="climb.id">
                {{ climb.date }}:
                <router-link :to="{ name: 'climb', params: {id: climb.id}}">{{ climb.name }}</router-link>
            </md-list-item>
        </md-list>
        <md-button
            class="md-fab md-fab-bottom-right"
            @click="newClimbDialogVisible = true"
            v-can:create="'Climb'"
        >
            <md-icon>add</md-icon>
        </md-button>

        <md-dialog
            :md-active.sync="newClimbDialogVisible"
            :md-fullscreen="false"
        >
            <div class="climb-add">
                <div class="row">
                    <md-field>
                        <label>Input name or place of climb there</label>
                        <md-input v-model="newClimb.name"></md-input>
                    </md-field>
                </div>
                <div class="row">
                    <span class="input-name">When: </span>
                    <datepicker
                        :monday-first="true"
                        :calendar-button="true"
                        calendar-button-icon="fa fa-calendar"
                        v-model="newClimb.date"
                        :value="newClimb.date"
                    ></datepicker>
                    <timepicker
                        :minute-interval="5"
                        v-model="newClimb.time"
                    ></timepicker>
                </div>
                <md-button class="md-primary md-raised" @click="addClimb">Add</md-button>
            </div>
        </md-dialog>
    </div>
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

