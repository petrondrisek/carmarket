<script setup lang="ts">
    const props = withDefaults(defineProps<{
    type?: 'button' | 'submit' | 'reset'
    }>(), {
    type: 'button'
    });
</script>

<template>
    <button 
        v-bind="$attrs"
        :type="props.type" 
        class="inline-flex items-center px-4 py-2 bg-secondary-900 dark:bg-dark_secondary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-700 dark:hover:bg-dark_secondary-500 focus:bg-secondary-400 dark:focus:bg-dark_secondary-500 active:bg-secondary-600 dark:active:bg-dark_secondary-700 focus:outline-none disabled:opacity-50 transition ease-in-out duration-150"
    >
        <slot></slot>
    </button>
</template>
