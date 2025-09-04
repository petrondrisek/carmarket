<script setup>
import { ref } from 'vue';

const getCurrentTheme = () => {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = saved ?? (prefersDark ? 'dark' : 'light');

    document.documentElement.classList.toggle('dark', theme === 'dark');

    return theme;
}

const currentTheme = ref(getCurrentTheme());

const switchTheme = () => {
    const theme = currentTheme.value === 'light' ? 'dark' : 'light';

    localStorage.setItem('theme', theme);
    currentTheme.value = theme;

    document.documentElement.classList.toggle('dark', theme === 'dark');
    window.dispatchEvent(new CustomEvent('onThemeChange', { detail: theme }));
}
</script>

<template>
    <button 
    @click="switchTheme"
    class="bg-primary-600 hover:bg-primary-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline dark:bg-dark_primary-700 dark:hover:bg-dark_primary-600"
    >
        Switch to 
        <span v-if="currentTheme === 'dark'">🌞</span>
        <span v-else>🌜</span>
    </button>
</template>