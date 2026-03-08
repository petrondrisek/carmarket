<script setup lang="ts">
const model = defineModel<string>({ default: '' });
</script>

<template>
    <select v-model="model" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        <slot name="options"></slot>
    </select>
</template>