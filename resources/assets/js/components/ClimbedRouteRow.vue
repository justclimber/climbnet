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
    var format = require('date-fns/format');
    import '../functions.js';
    export default {
        props: ['climbedRoute'],
        computed: {
            routeTitle() {
                var title = [];
                if (this.climbedRoute.name) {
                    title.push(this.climbedRoute.name);
                }
                if (this.climbedRoute.category_dict) {
                    title.push('{category} ({proposed_category})'.formatUnicorn({
                        category: this.category(this.climbedRoute.category_dict),
                        proposed_category: this.category(this.climbedRoute.proposed_category_dict)
                    }));
                } else {
                    title.push('?');
                }
                if (this.climbedRoute.ascent_type_dict) {
                    title.push(this.ascentType(this.climbedRoute.ascent_type_dict));
                }
                return title.join(' ');
            }
        },
        methods: {
            category(category_dict) {
                let categories = this.$store.state.settings.dicts.categories;
                for (let i = 0; i < categories.length; i++) {
                    if (category_dict === categories[i].value) {
                        return categories[i].text;
                    }
                }
            },
            ascentType(ascent_type) {
                let ascentTypes = this.$store.state.settings.dicts.ascent_types;
                for (let i = 0; i < ascentTypes.length; i++) {
                    if (ascent_type === ascentTypes[i].value) {
                        return ascentTypes[i].text;
                    }
                }
            }
        },
    }
</script>
<style lang="scss">
</style>
