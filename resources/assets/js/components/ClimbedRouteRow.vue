<template>
    <div>
        <v-subheader>
            <router-link :to="{ name: 'route-save', params: {route_id: climbedRoute.id}}">
                {{ climbedRoute.name }} {{ category(climbedRoute.category_dict) }} ({{ category(climbedRoute.proposed_category_dict) }})
            </router-link>
        </v-subheader>
    </div>
</template>
<script>
    var format = require('date-fns/format');
    export default {
        props: ['climbedRoute'],
        methods: {
            category(category_dict) {
                let categories = this.$store.state.settings.dicts.categories;
                for (let i = 0; i < categories.length; i++) {
                    if (category_dict === categories[i].value) {
                        return categories[i].text;
                    }
                }
            },
        },
    }
</script>
<style lang="scss">
</style>
