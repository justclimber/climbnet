<template>
    <div>
        <v-subheader>
            <router-link :to="{ name: 'route-save', params: {route_id: climbedRoute.id}}">
                {{ routeTitle }}
            </router-link>
        </v-subheader>
    </div>
</template>
<script>
    import { mapState } from 'vuex';
    import '../functions.js';
    export default {
        props: ['climbedRoute'],
        computed: {
            ...mapState(['settings']),
            routeTitle() {
                let title = [];
                if (this.climbedRoute.route_type_dict) {
                    title.push(this.routeType(this.climbedRoute.route_type_dict));
                }
                if (this.climbedRoute.name) {
                    title.push(this.climbedRoute.name);
                }
                if (this.climbedRoute.category_dict) {
                    title.push(this.category(this.climbedRoute.category_dict));
                } else {
                    title.push('?');
                }
                if (this.climbedRoute.proposed_category_dict) {
                    title.push('(' + this.category(this.climbedRoute.proposed_category_dict) + ')');
                }
                if (this.climbedRoute.ascent_type_dict) {
                    title.push(this.ascentType(this.climbedRoute.ascent_type_dict));
                }
                return title.join(' ');
            }
        },
        methods: {
            category(category_dict) {
                return this.settings.dicts.categories[category_dict];
            },
            routeType(route_type) {
                return this.settings.dicts.route_types[route_type];
            },
            ascentType(ascent_type) {
                return this.settings.dicts.ascent_types[ascent_type];
            }
        },
    }
</script>
<style lang="scss">
</style>
