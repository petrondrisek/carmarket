<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string,
    as: string,
}>();
</script>

<template>
    <div>
        <button v-if="props.as == 'button'" type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot></slot>
        </button>

        <a v-else-if="props.as =='a'" :href="props.href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot></slot>
        </a>

        <Link v-else :href="props.href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot></slot>
        </Link>
    </div>
</template>
