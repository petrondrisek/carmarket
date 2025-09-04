<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {type: String, default: ''},
});

const emit = defineEmits(['update:modelValue']);

const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
});
</script>

<template>
    <select v-model="value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
        <slot name="options"></slot>
    </select>
</template>