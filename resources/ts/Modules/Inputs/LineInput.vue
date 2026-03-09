<script setup lang="ts">
import { computed, onMounted, useTemplateRef } from 'vue';

const model = defineModel<string|number>({ default: '' });

interface Props {
    loading?: boolean;
    prefix?: string;
    type?: 'text' | 'password' | 'email' | 'number';
}

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    prefix: '',
    type: 'text'
});

const inputRef = useTemplateRef('inputRef');

const dynamicPadding = computed(() => {
    if (!props.prefix) return { paddingLeft: '0.75rem' };

    const width = (props.prefix.length * 0.65) + 0.75;
    return { paddingLeft: `${width}rem` };
});

onMounted(() => {
    if (inputRef.value?.autofocus) {
        inputRef.value.focus();
    }
});

defineExpose({ 
    $el: inputRef, 
    focus: () => inputRef.value?.focus()
 });
</script>

<template>
    <div class="relative">
        <span v-if="props.prefix" class="absolute top-0 left-0 m-2 text-gray-400">{{ props.prefix }}</span>

        <input
            v-bind="$attrs"
            ref="inputRef"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            v-model="model"
            :style="dynamicPadding"
            :disabled="props.loading"
            :type="props.type"
        />

        <div v-if="props.loading" class="flex flex-wrap gap-4">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-400">Loading...</span>
        </div>
    </div>
</template>
