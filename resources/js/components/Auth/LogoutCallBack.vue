<script setup>
import { onMounted } from 'vue';
import { useAuth0 } from '@auth0/auth0-vue';
import { useRouter } from 'vue-router';
import {useAuthStore} from './AuthStore.js'

const { handleRedirectCallback, getIdTokenClaims } = useAuth0();
const router = useRouter(); // Get the router instance

onMounted(async () => {
    console.log('Callback page logout ');
    try {
        await new Promise(resolve => setTimeout(resolve, 1000));
        useAuthStore().setToken(null)
        useAuthStore().setAuthenticated(false)
        router.push('/');
        // Handle the authentication callback and process the redirect
    } catch (error) {
        console.error('Error handling redirect callback:', error);
        router.push('/'); // Navigate to an error page or handle the error as needed
    }
});
</script>

<template>

</template>

<style scoped>

</style>
