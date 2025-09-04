<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ThemeSwitcher from '@/Components/Layout/ThemeSwitcher.vue';
import Nav from '@/Components/Layout/Nav.vue';
import ToastMessages from '@/Components/Toast/ToastMessages.vue';
import { provideToast } from '@/Composables/useToast';

defineProps({
    title: String
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Register toast composable
provideToast();
</script>

<template>
    <Head :title="title"></Head>

    <header class="max-w-7xl mx-auto mt-4 lg:mt-0 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <Link :href="route('app_dashboard')" class="flex items-center">
            <img src="/images/logo.png" alt="Logo" width="48px">
            <h1 class="text-2xl text-primary-500 font-bold dark:text-dark_primary-500">{{ appName }}</h1>
        </Link>

        <div class="flex items-center gap-2">
            <Nav></Nav>
            <ThemeSwitcher></ThemeSwitcher>
        </div>
    </header>

    <main class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <ToastMessages />
        <slot></slot>
    </main>

    <footer class="mt-8 px-4 sm:px-6 lg:px-8 border-t-2 border-gray-300 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-8">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ new Date().getFullYear() }} {{ appName }} | Petr Ondříšek | All rights reserved
            </p>
        </div>
    </footer>
</template>