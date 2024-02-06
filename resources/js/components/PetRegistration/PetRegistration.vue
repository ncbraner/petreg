<template>
    <div class="bg-gray-100 flex flex-col items-center justify-center space-y-4">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-center mb-4">
                <span class="paw"></span>
                <span class="paw"></span>
                <span class="paw"></span>
            </div>
            <form @submit.prevent="submitForm" class="mb-4">
                <h1 class="text-gray-900 text-xl font-bold mb-4">Tell us about your pet</h1>
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">What type of pet is
                        it?</label>
                    <select id="type" v-model="form.type" @focus="clearError('type')" @blur="validateField('type')"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm"
                            required>
                        <option disabled value="">Please select one</option>
                        <option>Cat</option>
                        <option>Dog</option>
                        <option>Snake</option>
                    </select>
                    <p class="text-red-500 text-xs italic" v-if="formErrors.type">{{ formErrors.type }}</p>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">What is your pet's
                        name?</label>
                    <input type="text" id="name" v-model="form.name" @focus="clearError('name')"
                           @blur="validateField('name')" placeholder="Monte"
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm"
                           required>
                    <p class="text-red-500 text-xs italic" v-if="formErrors.name">{{ formErrors.name }}</p>
                </div>
                <div class="mb-4">
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-2">What breed are they?</label>
                    <select id="breed" v-model="form.breed" @focus="clearError('breed')" @blur="validateField('breed')"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm"
                            required>
                        <option disabled value="">Please select one</option>
                        <option v-for="breed in breeds" :key="breed.id" :value="breed.id">{{
                                breed.breed_name
                            }}
                        </option>
                        <option value="1">Can't find it?</option>
                    </select>
                    <p class="text-red-500 text-xs italic" v-if="formErrors.breed">{{ formErrors.breed }}</p>
                </div>
                <div v-if="form.breed === '1'">
                    <input type="radio" id="unknown" value="I don’t know" v-model="form.breedDetail">
                    <label for="unknown">I don’t know</label><br>
                    <input type="radio" id="mix" value="It’s a mix" v-model="form.breedDetail">
                    <label for="mix">It’s a mix</label><br>
                    <input v-if="form.breedDetail === 'It’s a mix'" type="text" id="mixDetail" v-model="form.mixDetail"
                           placeholder="Enter the mix"
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm"
                           maxlength="200" required>
                    <p class="text-red-500 text-xs italic" v-if="formErrors.breedDetail">{{
                            formErrors.breedDetail
                        }}</p>
                </div>
                <div class="mb-6">
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">What gender are
                        they?</label>
                    <select id="gender" v-model="form.gender"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm"
                            required>
                        <option disabled value="">Please select one</option>
                        <option>Female</option>
                        <option>Male</option>
                    </select>
                    <p class="text-red-500 text-xs italic" v-if="formErrors.gender">{{ formErrors.gender }}</p>
                </div>
                <div>
                    <button type="submit"
                            :class="{'bg-blue-700 hover:bg-blue-800': form.type && form.name && form.breed && form.gender, 'bg-gray-300': !form.type || !form.name || !form.breed || !form.gender}"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:border-blue-700 focus:ring-blue active:bg-blue-700 transition ease-in-out duration-150">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import {ref, watch, onMounted} from 'vue';
import {useAuthStore} from "../Auth/AuthStore.js";

const AuthStore = useAuthStore();
const token = AuthStore.token;
const authId = AuthStore.authId;
const rules = ref({});
const formRules = ref({});
const form = ref({
    name: '',
    type: '',
    breed: '',
    breedDetail: '',
    gender: '',
    mixDetail: '',
});
const breeds = ref([]);
const formErrors = ref({});
const petRegistrations = ref([]);

const generateFormRules = (rulesJson) => {
    const rulesObj = JSON.parse(rulesJson);
    let setFormRules = {};

    for (let key in rulesObj) {
        setFormRules[key] = {
            required: rulesObj[key].includes('required'),
            string: rulesObj[key].includes('string'),
            in: rulesObj[key].find(rule => rule.startsWith('in:'))?.replace('in:', '').split('","').map(s => s.replace(/"/g, '')),
            max: rulesObj[key].find(rule => rule.startsWith('max:'))?.replace('max:', ''),
            nullable: rulesObj[key].includes('nullable'),
            int: rulesObj[key].includes('int')
        };
    }

    return setFormRules;
};

onMounted(async () => {
    const response = await fetch('/api/validation-rules');
    const data = await response.json();
    rules.value = data;
    formRules.value = generateFormRules(rules.value);
});

watch(() => form.value.type, async (newType) => {
    if (newType) {
        const response = await fetch(`/api/breeds?type=${newType}`);
        const data = await response.json();
        breeds.value = data;
    }
});

watch(() => form.value.breed, (newBreed) => {
    const selectedBreed = breeds.value.find(breed => breed.id === newBreed);
    if (selectedBreed) {
        form.value.breedDetail = selectedBreed.breed_name;
    }
    if (form.value.breed === '1') {
        form.value.breedDetail = 'Can\'t find it?';
    }
    if (form.value.breed !== '1') {
        form.value.mixDetail = '';
    }
});

watch(() => form.value.breedDetail, (newBreedDetail) => {
    if (newBreedDetail === 'I don’t know') {
        form.value.mixDetail = '';
    }
});


watch(() => form.value.breedDetail, () => {
    validateField('breedDetail');
});

watch(() => form.value.mixDetail, () => {
    validateField('mixDetail');
});

const validateField = (field) => {

    formErrors.value[field] = null; // Clear the old error


    let value = typeof form.value[field] === 'string' ? form.value[field].toLowerCase() : form.value[field];

    if (formRules.value[field]) {
        if (formRules.value[field].required && !value) {
            formErrors.value[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} is required`;
        }
        if (formRules.value[field].string && typeof value !== 'string') {
            formErrors.value[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} must be a string`;
        }
        if (formRules.value[field].in && !formRules.value[field].in.includes(value)) {
            formErrors.value[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} must be one of ${formRules.value[field].in.map(value => value.charAt(0).toUpperCase() + value.slice(1)).join(', ')}`;
        }
        if (formRules.value[field].max && value.length > formRules.value[field].max) {
            formErrors.value[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} must be less than ${formRules.value[field].max} characters`;
        }
        if (formRules.value[field].int && !Number.isInteger(Number(value))) {
            formErrors.value[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} must be an integer`;
        }
    }
};

const clearError = (field) => {
    formErrors.value[field] = null;
};


const validateForm = () => {
    formErrors.value = {};
    let isValid = true;

    for (let key in form.value) {
        validateField(key);
        if (formErrors.value[key]) {
            isValid = false;
        }
    }
    return isValid;
};

const submitForm = async () => {
    if (!validateForm()) {
        console.error('Form validation failed');
        return;
    }
    form.value.authID = authId;

    const apiEndpoint = '/api/pet-registrations';
    try {
        // Check if the token is valid
        if (token) {
            const response = await fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(form.value)
            });
            const data = await response.json();
            console.log('Success:', data);
            // Reset the form after successful submission
            form.value = {
                name: '',
                type: '',
                breed: '',
                breedDetail: '',
                gender: '',
                mixDetail: '',
            };
        } else {
            console.error('Invalid token');
        }
    } catch (error) {
        console.error('Error:', error.message);
    }
};

const fetchPetRegistrations = async () => {
    const userId = 1;
    const apiEndpoint = `/api/pet-registrations?user_id=${userId}`;
    try {
        const response = await fetch(apiEndpoint, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });
        const data = await response.json();
        petRegistrations.value = data;
    } catch (error) {
        console.error('Error:', error);
    }
};

defineExpose({
    form,
    submitForm,
    breeds,
    fetchPetRegistrations,
    petRegistrations,
    formErrors,
    clearError,
    token,
    AuthStore
});
</script>

<style scoped>
/* ... your style code ... */
</style>
