<script lang="ts" setup>
    const props = withDefaults(
        defineProps<{ 
            href?: string 
        }>(), {
            href: '#'
        });
</script>

<template>
    <a 
        :href="props.href" 
        class="text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400"
    >
        <slot></slot>
    </a>
</template>