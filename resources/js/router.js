// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import PetRegistration from './components/PetRegistration/PetRegistration.vue';
import PetList from './components/PetLists/PetList.vue';
import Welcome from './components/Base.vue';
import Callback from './components/Auth/Callback.vue'; // Import the Callback component
import LogOutCallback from './components/Auth/LogoutCallBack.vue'; // Import the Callback component
import { authGuard } from "@auth0/auth0-vue";


function auth0CallbackGuard(to, from, next) {
    // Get the origin of the request
    let origin = document.location.search;

    // Check if the origin is Auth0
    if (origin.includes('code=')) {
        next();
    } else {
        next(false);
    }
}

const routes = [
    { path: '/', component: Welcome, meta: { name: 'Welcome',showInNav: true } },
    { path: '/register', component: PetRegistration, meta: { name: 'Pet Registration', beforeEnter: authGuard, showInNav: true }},
    { path: '/list', component: PetList, meta: { name: 'Pet List', beforeEnter: authGuard, showInNav: true }},
    { path: '/auth0_callback', component: Callback, meta: { name: 'Callback' }, beforeEnter: auth0CallbackGuard },
    { path: '/auth0_callback_logout', component: LogOutCallback, meta: { name: 'LogOutCallback' } } // Add the callback route
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
