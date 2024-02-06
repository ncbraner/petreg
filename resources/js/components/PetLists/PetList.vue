<template>
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full lg:max-w-full">
        <table class="w-full table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2 lg:table-cell hidden">Breed</th>
                <th class="px-4 py-2 lg:table-cell hidden">Gender</th>
                <th class="px-4 py-2 lg:table-cell hidden">Mix Detail</th>
                <th class="px-4 py-2">Registration Number</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="pet in store.list" :key="pet.id" class="text-center border-b border-gray-200">
                <td class="px-4 py-2">{{ pet.name }}</td>
                <td class="px-4 py-2">{{ pet.type }}</td>
                <td class="px-4 py-2 lg:table-cell hidden">{{ pet.breed_detail }}</td>
                <td class="px-4 py-2 lg:table-cell hidden">{{ pet.gender }}</td>
                <td class="px-4 py-2 lg:table-cell hidden">{{ pet.mix_detail }}</td>
                <td class="px-4 py-2">{{ pet.pet_registration_number }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { usePetRegistrationsStore } from './petListStore';
import { useAuthStore } from '../Auth/AuthStore';

const authStore = useAuthStore();
const store = usePetRegistrationsStore();

onMounted(async () => {
    // Fetch pet registrations for the authenticated user
    try {
        await store.fetchPetRegistrations(authStore.authId, authStore.token);
    } catch (error) {
        console.error('Failed to fetch pet registrations:', error);
    }
});
</script>

<style scoped>

</style>
