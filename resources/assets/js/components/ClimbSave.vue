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
                <v-ons-input placeholder="Input name or place of climb there" float
                             v-model="name"
                >
                </v-ons-input>
            </v-ons-list-item>
            <v-ons-list-item>
                <v-ons-button @click="save">Save</v-ons-button>
            </v-ons-list-item>
        </v-ons-list>
    </v-ons-page>
</template>

<script>
    export default {
        data() {
            return {
                name: ''
            }
        },
        methods: {
            save() {
                alert(this.name);
            }
        },
        mounted() {
            axios.get('/climbs')
                .then(response => this.climbs = response.data.data);
        }
    }
</script>
<style scoped="">
    ons-input {
        width:100%;
    }
</style>
