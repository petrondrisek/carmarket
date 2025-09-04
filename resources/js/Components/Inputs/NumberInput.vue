<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {type: String, default: ''},
    prefix: {type: String, default: ''}
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <div class="relative">
        <span v-if="prefix" class="absolute top-0 left-0 m-2 text-gray-400">{{ prefix }}</span>
        <input
            ref="input"
            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            :style="{ paddingLeft: ((prefix.length * 0.6) + 1) + 'rem' }"
            :value="modelValue"
            type="number"
            @input="$emit('update:modelValue', $event.target.value)"
        >
    </div>
</template>
