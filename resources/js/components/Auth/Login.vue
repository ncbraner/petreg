<template>
    <div>
        <button @click="login">
            Log in
        </button>
    </div>
</template>

<script setup>
import {useAuth0} from '@auth0/auth0-vue';

const {loginWithRedirect, user, isAuthenticated} = useAuth0();

const login = () => {
    loginWithRedirect().catch(error => {
        console.error("Failed to log in:", error);
    });
};
</script>
