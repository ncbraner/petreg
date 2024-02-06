<template>
    <div>
        <!-- You can add some loading spinner here while the authentication is being processed -->
    </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { useAuth0 } from '@auth0/auth0-vue';
import { useRouter } from 'vue-router';
import {useAuthStore} from './AuthStore.js'

const {isAuthenticated, user } = useAuth0();
const router = useRouter(); // Get the router instance

const { getAccessTokenSilently } = useAuth0();

const store = useAuthStore();

watch(store, () => {}, { deep: true });

async function getAccessTokenWithRetry(getAccessTokenSilently, retries = 3, delay = 1000) {
    for (let i = 0; i < retries; i++) {
        try {
            return await getAccessTokenSilently();
        } catch (error) {
            await new Promise(resolve => setTimeout(resolve, delay));
        }
    }
    throw new Error('Failed to get access token after multiple attempts');
}

onMounted(async () => {
    console.log('Callback page');
    await new Promise(resolve => setTimeout(resolve, 1000));

    const token = await getAccessTokenWithRetry(getAccessTokenSilently);

    if (isAuthenticated.value) {
        try {
            store.setToken(token)
            store.setAuthenticated(true)
            const authid = user.value.sub;
            store.setAuthId(authid);
            const response = await fetch(`${import.meta.env.VITE_API_URL}/get-user?authId=${authid}`, {
                method: 'GET',
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            // show profile page if user is not registered TODO

            router.push('/');
        } catch (error) {
            router.push('/'); // Navigate to an error page or handle the error as needed
        }
    }
});
</script>
