import { defineStore } from 'pinia';
import { useStorage } from '@vueuse/core'

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => {
        return {
            isAuthenticated: useStorage('isAuthenticated', false),
            token: useStorage('token', null),
            authId: useStorage('authId', null),
        };
    },
    actions: {
        setAuthenticated(isAuthenticated) {
            if (typeof isAuthenticated !== 'boolean') {
                throw new Error('isAuthenticated must be a boolean');
            }
            this.isAuthenticated = isAuthenticated;
        },
        setToken(token) {
            if (typeof token !== 'string' && token !== null) {
                throw new Error('token must be a string');
            }
            this.token = token;
        },
        setAuthId(authId) {
            if (typeof authId !== 'string') {
                throw new Error('authId must be a string');
            }
            this.authId = authId;
        },
    },
});
