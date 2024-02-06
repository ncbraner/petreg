// petListStore.js
import { defineStore } from 'pinia';

// Custom deep comparison function
function deepEqual(a, b) {
    if (a === b) return true;

    if (typeof a !== 'object' || a === null || typeof b !== 'object' || b === null) return false;

    let keysA = Object.keys(a), keysB = Object.keys(b);

    if (keysA.length !== keysB.length) return false;

    for (let key of keysA) {
        if (!keysB.includes(key) || !deepEqual(a[key], b[key])) return false;
    }

    return true;
}

export const usePetRegistrationsStore = defineStore({
    id: 'petRegistrations',
    state: () => ({
        list: [],
    }),
    actions: {
        // Fetch pet registrations for a given authId and token
        async fetchPetRegistrations(authId, token) {
            const apiEndpoint =`/api/pet-registrations?authId=${authId}`; // Use environment variable for API endpoint
            try {
                const response = await fetch(apiEndpoint, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                });
                const data = await response.json();
                // Compare each record with the existing ones in the store
                const updatedRecords = data.filter(item => {
                    const existingItem = this.list.find(existingItem => existingItem.id === item.id);
                    return !existingItem || !deepEqual(existingItem, item);
                });
                // Append updated records to the existing store
                this.list = [...this.list.filter(item => !updatedRecords.some(updatedItem => updatedItem.id === item.id)), ...updatedRecords];
            } catch (error) {
                console.error('Error fetching pet registrations:', error.message);
            }
        },
    },
});
