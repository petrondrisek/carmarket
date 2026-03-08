<script setup lang="ts">
const checked = defineModel<boolean | Array<string>>('checked', { default: false });

const props = defineProps<{
    value?: string | null
}>();
</script>


<template>
    <input
        v-model="checked"
        type="checkbox"
        :value="props.value"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    >
</template>
