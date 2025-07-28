<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const isLoading = ref(false);

const submit = () => {
    isLoading.value = true;
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
};

onMounted(() => {
    // Add subtle parallax effect to background
    const handleMouseMove = (e) => {
        const { clientX, clientY } = e;
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;
        const moveX = (clientX - centerX) / 50;
        const moveY = (clientY - centerY) / 50;

        document.documentElement.style.setProperty('--mouse-x', `${moveX}px`);
        document.documentElement.style.setProperty('--mouse-y', `${moveY}px`);
    };

    window.addEventListener('mousemove', handleMouseMove);

    return () => {
        window.removeEventListener('mousemove', handleMouseMove);
    };
});
</script>

<template>
    <Head title="Famous Production - Sign In" />

    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-primary-400 via-primary-200 to-primary-50">
        <!-- Elegant Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <!-- Frosted Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Frosted Lens Effect -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-primary-100/40 to-primary-200/40 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-gradient-to-r from-accent-50/30 to-accent-100/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <!-- Frosted Top/Bottom Fade -->
            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-primary-400/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-primary-400/30 to-transparent"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Famous Production Branding -->
                <div class="text-center mb-12">
                    <!-- Logo -->
                    <div class="mx-auto mb-8">
                        <div class="relative">
                            <!-- Camera Icon -->
                            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center shadow-2xl mb-4">
                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <!-- Brand Name -->
                            <h1 class="text-4xl font-light text-primary-500 mb-2 tracking-wider">FAMOUS</h1>
                            <h2 class="text-xl font-light text-primary-200 tracking-widest">PRODUCTION</h2>
                            <!-- Elegant Line -->
                            <div class="mt-4 mx-auto w-16 h-px bg-gradient-to-r from-transparent via-primary-200 to-transparent"></div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-light text-primary-500/90 mb-2">Welcome Back</h3>
                    <p class="text-secondary-500 font-light">Sign in to access your creative workspace</p>
                </div>
                <!-- Status Message -->
                <div v-if="status" class="mb-8 p-4 bg-success-100 border border-success-200 rounded-2xl text-success-700 text-sm backdrop-blur-sm">
                    {{ status }}
                </div>
                <!-- Login Form -->
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-primary-100">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
            <div>
                            <label for="email" class="block text-sm font-medium text-primary-500 mb-3">
                                Email Address
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-primary-200 group-focus-within:text-primary-100 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                                    class="block w-full pl-12 pr-4 py-4 bg-primary-50 border border-primary-100 rounded-2xl text-primary-500 placeholder-primary-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-all duration-300"
                                    placeholder="Enter your email address"
                                />
                            </div>
                            <div v-if="form.errors.email" class="mt-2 text-error-500 text-sm">
                                {{ form.errors.email }}
                            </div>
                        </div>
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-primary-500 mb-3">
                                Password
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-primary-200 group-focus-within:text-primary-100 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
            </div>
                                <input
                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                                    class="block w-full pl-12 pr-12 py-4 bg-primary-50 border border-primary-100 rounded-2xl text-primary-500 placeholder-primary-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-all duration-300"
                                    placeholder="Enter your password"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-primary-200 hover:text-primary-100 transition-colors"
                                >
                                    <svg v-if="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                    <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div v-if="form.errors.password" class="mt-2 text-error-500 text-sm">
                                {{ form.errors.password }}
                            </div>
            </div>
                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.remember"
                                    class="h-4 w-4 text-primary-400 focus:ring-primary-200 border-primary-100 rounded bg-primary-50"
                                />
                                <span class="ml-3 text-sm text-secondary-500">Remember me</span>
                            </label>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-primary-200 hover:text-primary-100 transition-colors duration-200 font-medium"
                            >
                                Forgot password?
                            </Link>
            </div>
                        <!-- Sign In Button -->
                        <button
                            type="submit"
                            :disabled="form.processing || isLoading"
                            class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-sm font-medium rounded-2xl text-white bg-gradient-to-r from-primary-400 to-primary-200 hover:from-primary-500 hover:to-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-200/25"
                        >
                            <span v-if="isLoading" class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            <span v-if="isLoading">Signing in...</span>
                            <span v-else class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign In
                            </span>
                        </button>
                        <!-- Elegant Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-primary-100"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-transparent text-secondary-400 font-light">or continue with</span>
                    </div>
                </div>
                        <!-- Google Sign In -->
                    <a
                        :href="route('google.login')"
                            class="w-full inline-flex justify-center items-center py-4 px-6 border border-primary-100 rounded-2xl shadow-sm bg-primary-50 text-sm font-medium text-primary-500 hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 transition-all duration-300"
                    >
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                            Sign in with Google
                        </a>
                        <!-- Sign Up Link -->
                        <div class="text-center pt-4">
                            <p class="text-secondary-400 text-sm font-light">
                                Don't have an account?
                                <Link :href="route('register')" class="font-medium text-primary-200 hover:text-primary-100 transition-colors duration-200">
                                    Create one here
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-secondary-400 text-xs font-light">
                        © 2024 Famous Production. Crafting visual stories with passion.
                    </p>
                </div>
            </div>
        </div>
            </div>
</template>

<style scoped>
:root {
    --mouse-x: 0px;
    --mouse-y: 0px;
}
.absolute {
    transform: translate(var(--mouse-x), var(--mouse-y));
    transition: transform 0.1s ease-out;
}
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-track {
    background: theme('colors.primary.50');
}
::-webkit-scrollbar-thumb {
    background: theme('colors.primary.200');
    border-radius: 3px;
}
::-webkit-scrollbar-thumb:hover {
    background: theme('colors.primary.300');
}
input:focus {
    box-shadow: 0 0 0 3px theme('colors.primary.100');
}
button:hover:not(:disabled) {
    transform: translateY(-1px);
}
.backdrop-blur-xl {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}
.font-light {
    font-weight: 300;
}
.tracking-wider {
    letter-spacing: 0.05em;
}
.tracking-widest {
    letter-spacing: 0.1em;
}
</style>
