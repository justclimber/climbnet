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
                <v-ons-button @click="save">Save</v-ons-button>
            </v-ons-list-item>
        <!--</v-ons-list>-->
    </v-ons-page>
</template>

<script>
    import Vue from 'vue';
    import Datepicker from 'vuejs-datepicker';
    import VueTimepicker from 'vue2-timepicker'

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
            }
        },
        computed: {
            datetime() {
                let date = new Date(this.date);
                return date.toISOString().substring(0, 10) + ' ' + this.time.HH + ':' + this.time.mm;
            }
        },
        methods: {
            save() {
                axios.post('/climbs', {
                    name: this.name,
                    date: this.datetime
                }).then(response => {
                    this.$router.push({name: 'climbs'})
                });
            }
        },
        mounted() {
            axios.get('/climbs')
                .then(response => this.climbs = response.data.data);
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
    /*.vdp-datepicker__calendar {*/
        /*position: fixed !important;*/
    /*}*/
</style>
