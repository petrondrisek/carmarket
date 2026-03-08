<script setup lang="ts">
import { useTheme } from './useTheme';
import { Theme } from './theme.models';

const { theme, changeTheme } = useTheme();
</script>

<template>
    <button 
    @click="changeTheme(theme === Theme.Light ? Theme.Dark : Theme.Light)"
    class="bg-primary-600 hover:bg-primary-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline dark:bg-dark_primary-700 dark:hover:bg-dark_primary-600"
    >
        Switch to 
        <span v-if="theme === Theme.Dark">🌞</span>
        <span v-else>🌜</span>
    </button>
</template>