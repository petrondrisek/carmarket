<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button 
    :type="type" 
    class="inline-flex items-center px-4 py-2 bg-primary-500 dark:bg-dark_primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-400 dark:hover:bg-dark_primary-500 focus:bg-primary-400 dark:focus:bg-dark_primary-500 active:bg-primary-600 dark:active:bg-dark_primary-700 focus:outline-none disabled:opacity-50 transition ease-in-out duration-150"
    >
        <slot></slot>
    </button>
</template>
