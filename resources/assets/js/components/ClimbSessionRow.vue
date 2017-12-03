<template>
    <div>
        <v-subheader>
            {{ formatDate(climb.date) }}:
            <router-link :to="{ name: 'climb', params: {id: climb.id}}">{{ climb.name }}</router-link>
        </v-subheader>
    </div>
</template>
<script>
    var format = require('date-fns/format');
    export default {
        props: ['climb'],
        methods: {
            formatDate(date) {
                return format(date, 'D MMM YYYY hh:mm');
            },
        },
    }
</script>
<style lang="scss">
</style>
