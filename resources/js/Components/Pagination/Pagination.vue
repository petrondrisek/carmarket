<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array
});
</script>

<template>
    <div class="flex items-center gap-2">
        <Link 
            v-for="link in links" 
            :key="link.id" 
            :href="link.url ?? '#'" 
            class="text-white px-3 py-2 rounded"
            :class="{ 
                'bg-gray-800 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-700': link.active, 
                'bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500': !link.active,
                'hidden': !link.url
            }"
            v-html="link.label"
        ></Link>
    </div>
</template>