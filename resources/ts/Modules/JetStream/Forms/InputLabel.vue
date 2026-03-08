<script setup lang="ts">
const props = defineProps<{
    value?: string,
}>();
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-400">
        <span v-if="props.value">{{ props.value }}</span>
        <span v-else>
            <slot></slot>
        </span>
    </label>
</template>
