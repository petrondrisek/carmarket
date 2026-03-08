<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps<{
    routeName: string;
    component?: string;
    external?: boolean;
}>();

const active = computed(() => props.component === usePage().component);
const emit = defineEmits(['linkClicked']);

</script>

<template>
  <a v-if="external" 
  :href="props.routeName" 
  class="block text-sm m-6 group relative w-max"
  >
    <slot></slot>
    <span class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-primary-600 dark:bg-dark_primary-600 group-hover:w-3/6"></span>
    <span class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-primary-600 dark:bg-dark_primary-600 group-hover:w-3/6"></span>
  </a>
  
  <Link
    v-else
    :href="route(props.routeName)"
    class="block text-sm m-6 group relative w-max"
    :class="{ 'text-primary-600 dark:text-dark_primary-600': active }"
    @click="emit('linkClicked')"
    >
     <slot></slot>
     <span v-if="!active" class="absolute -bottom-1 left-1/2 w-0 transition-all h-0.5 bg-primary-600 dark:bg-dark_primary-600 group-hover:w-3/6"></span>
     <span v-if="!active" class="absolute -bottom-1 right-1/2 w-0 transition-all h-0.5 bg-primary-600 dark:bg-dark_primary-600 group-hover:w-3/6"></span>
   </Link>
</template>