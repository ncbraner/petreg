<script setup>
import { onMounted, computed } from 'vue';
import { useRouter, onBeforeRouteUpdate } from 'vue-router';
import { useAuthStore } from './Auth/AuthStore.js';
import { useAuth0 } from '@auth0/auth0-vue';

const { handleRedirectCallback, getIdTokenClaims, user, getAccessTokenSilently } = useAuth0();
const router = useRouter();
const store = useAuthStore();
const isAuthenticated = computed(() => store.isAuthenticated);

// Function to load the authentication state
const loadAuthState = async () => {
    // const token = await getAccessTokenSilently();
    // try {
    //     // Check if the token is valid
    //     if (token) {
    //         store.setToken(token)
    //         store.setAuthenticated(true)
    //     } else {
    //         console.error('Invalid token');
    //     }
    // } catch (error) {
    //     console.error('Error handling redirect callback:', error.message);
    //     router.push('/');
    // }
};

onMounted(loadAuthState);
onBeforeRouteUpdate(loadAuthState);
</script>

<template>
    <h1>Welcome</h1>
    <h2 v-if="isAuthenticated">You are logged in Register your pet</h2>
    <h2 v-else>Please login above</h2>
</template>

<style scoped>
/* Your styles here */
</style>
