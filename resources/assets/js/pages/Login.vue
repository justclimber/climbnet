<template>
    <v-ons-page>
        <div class="login">
            <button class="button" @click="vkLogin">Login via VK</button>
        </div>
    </v-ons-page>
</template>

<script>
    import Vk from '../vk.js'
    VK.init({
        apiId: 6249533
    });
    export default {
        methods: {
            vkLogin() {
                VK.Auth.login(this.vkLoginCallback, VK.access.PHOTOS + VK.access.FRIENDS);
            },

            vkLoginCallback(response) {
                api.save('session', response.session).then(data => {
                    this.$store.dispatch('serUser', data.data.user);
                    this.$router.push({name: 'climbs'});
                });
//                VK.Api.call('photos.getAlbums', {}, function(r) {
//                    console.log(r);
//                });
            }
        }
    }
</script>

<style lang="scss">
    .login {
        position: absolute;
        margin: auto;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 100px;
    }
</style>