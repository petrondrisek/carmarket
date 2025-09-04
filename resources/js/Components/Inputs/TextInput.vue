<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    loading: {type: Boolean, default: false},
    prefix: {type: String, default: ''},
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
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-bind="$attrs"
            :style="{ paddingLeft: ((prefix.length * 0.6) + 1) + 'rem' }"
        >
    </div>
</template>

<script>
export default { inheritAttrs: false };
</script>
