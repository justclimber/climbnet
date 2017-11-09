<template>
    <v-ons-page>
        Login via <button @click="vkLogin">VK</button>
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
                console.log('vk login started');
                VK.Auth.login(this.vkLoginCallback, VK.access.PHOTOS + VK.access.FRIENDS);
            },

            vkLoginCallback(response) {
                console.log(response);
                console.log('vk login callback');
                axios.post('/api/session', response.session);
//                VK.Api.call('photos.getAlbums', {}, function(r) {
//                    console.log(r);
//                });

            }
        }
    }
</script>