// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import router from './router'
import NavBar from "./components/NavBar.vue";
import { pinia } from "./store.js";
import { useAuthStore } from './components/Auth/AuthStore';
import { createAuth0 } from '@auth0/auth0-vue'; // Import the Auth0Plugin and useAuth

const app = createApp({});
// Create an instance of the Auth0 client
const auth0 = createAuth0({
    domain: import.meta.env.VITE_AUTH0_DOMAIN,
    clientId: import.meta.env.VITE_AUTH0_CLIENT_ID,
    cacheLocation: 'localstorage',
    authorizationParams: {
        redirect_uri: window.location.origin + '/auth0_callback',
        audience: import.meta.env.VITE_AUTH0_AUDIENCE,
    }
    // You can add more options here. Check the Auth0 documentation for more details.
});

app.component('nav-bar', NavBar);
app.use(pinia);
app.use(router);
// Install the Auth0Plugin
app.use(auth0);

// Get the auth store
const as  = useAuthStore()

app.mount('#app');
