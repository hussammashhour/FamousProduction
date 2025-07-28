<template>
    <div class="max-w-md mx-auto mt-8">
        <form @submit.prevent="handleLogin" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    v-model="form.email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email"
                    type="email"
                    placeholder="Email"
                    required
                />
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    v-model="form.password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="password"
                    type="password"
                    placeholder="******************"
                    required
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="device_name">
                    Device Name (Optional)
                </label>
                <input
                    v-model="form.device_name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="device_name"
                    type="text"
                    placeholder="e.g., iPhone, Desktop"
                />
            </div>

            <div class="flex items-center justify-between">
                <button
                    :disabled="loading"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
                    type="submit"
                >
                    {{ loading ? 'Logging in...' : 'Sign In' }}
                </button>
            </div>

            <div v-if="error" class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ error }}
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useAuth } from '../../composables/useAuth';

const { login } = useAuth();

const loading = ref(false);
const error = ref('');

const form = reactive({
    email: '',
    password: '',
    device_name: ''
});

const handleLogin = async () => {
    loading.value = true;
    error.value = '';

    try {
        const result = await login({
            email: form.email,
            password: form.password,
            device_name: form.device_name || undefined
        });

        if (result.success) {
            // Redirect to dashboard or home page
            window.location.href = '/dashboard';
        } else {
            error.value = result.error;
        }
    } catch (err) {
        error.value = 'An unexpected error occurred';
        console.error('Login error:', err);
    } finally {
        loading.value = false;
    }
};
</script>
