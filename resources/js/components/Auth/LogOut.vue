<template>
    <div>
        <button @click="logoutUser">Log out</button>
    </div>
</template>

<script setup>
import { useAuth0 } from '@auth0/auth0-vue';

const { logout } = useAuth0();

const logoutUser = () => {
    logout({ logoutParams: { returnTo: window.location.origin + '/auth0_callback_logout' } })
        .catch(error => {
            console.error("Failed to log out:", error);
        });
};
</script>
