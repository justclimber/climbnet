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
                    <option v-for="category in categoriesDict" :value="category.value">
                        {{ category.text }}
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

    Vue.component('datepicker', Datepicker);
    Vue.component('timepicker', VueTimepicker);

    export default {
        data() {
            return {
                name: '',
                category_dict: '',
                categoriesDict: [
                    {value: 4, text: '6a'},
                    {value: 5, text: '6a+'},
                    {value: 6, text: '6b'},
                    {value: 7, text: '6b+'},
                    {value: 8, text: '6c'},
                    {value: 9, text: '6c+'},
                    {value: 10, text: '7a'},
                ],
            }
        },
        computed: {
        },
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
