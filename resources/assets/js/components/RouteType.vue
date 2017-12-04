<template>
    <div>
        <v-select
            :label="label"
            @click.native="routeTypeDialog = true"
            v-bind:items="settings.dicts.route_types"
            v-model="routeType"
            readonly
        ></v-select>
        <v-dialog v-model="routeTypeDialog">
            <v-card>
                <v-container>
                    <h2 class="text-xs-center">Route Type</h2>
                    <v-layout row wrap class="text-xs-center">
                        <v-flex xs-4 v-for="(image, index) in images" :key="index">
                            <v-card flat tile>
                                <img
                                    :src="`/images/route_type/${image}.jpg`"
                                    class="image elevation-5 pa-1"
                                    height="130px"
                                    width="130px"
                                    :data-value="image"
                                    @click="selectType"
                                >
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import { mapState } from 'vuex';
    export default {
        props: ['label', 'value'],
        computed: {
            ...mapState(['settings']),
            routeType() {
                return this.value ? this.value : this.routeTypeSelected
            }
        },
        data() {
            return {
                images: ['lead', 'toprope', 'bouldering', 'trad'],
                routeTypeDialog: false,
                routeTypeSelected: this.value,
            }
        },
        methods: {
            selectType(event) {
                this.routeTypeDialog = false;
                let routeTypes = this.settings.dicts.route_types;
                for (let i = 0; i < routeTypes.length; i++) {
                    if (routeTypes[i].value === this.images.indexOf(event.target.dataset.value) + 1) {
                        this.routeTypeSelected = routeTypes[i];
                        this.$emit('input', routeTypes[i].value);
                        break;
                    }
                }
            },
        },
    }
</script>
<style lang="scss">
</style>