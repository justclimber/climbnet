<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left">
                <v-ons-back-button>To climbs</v-ons-back-button>
            </div>
            <div class="center">Add a climb</div>
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
            }
        },
        computed: mapState(['settings']),
        methods: {
            saveRoute() {

            },
            saveAndAddNewRoute() {

            },
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
