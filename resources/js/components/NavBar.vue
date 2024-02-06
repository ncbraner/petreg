<template>
    <nav class="bg-blue-500 p-4">
        <ul class="flex justify-around md:justify-end space-x-4 md:space-x-8">
            <router-link
                v-for="(route, index) in $router.options.routes.filter(route => route.meta.showInNav)"
                :key="index"
                :to="route.path"
                class="text-white text-lg md:text-xl hover:text-gray-200">
                <li>{{ route.meta.name }}</li>
            </router-link>
            <li class="text-white text-lg md:text-xl hover:text-gray-200">
                <Login v-if="!isAuthenticated" />
                <Logout v-else />
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { useAuth0 } from '@auth0/auth0-vue';
import Login from './Auth/Login.vue';
import Logout from './Auth/LogOut.vue';

const { isAuthenticated } = useAuth0();
</script>

<style scoped>
/* No changes here */
</style>
