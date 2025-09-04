<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import { computed } from 'vue';

const props = defineProps({
    modelValue: {type: String, default: ''},
});

const emit = defineEmits([
    'update:modelValue'
]);

const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
});
</script>

<template>
    <quill-editor
        theme="bubble"  
        :content="value" 
        :content-type="'html'" 
        @update:content="value = $event" 
        placeholder="Content..."
        tabindex="0"
        toolbar="full"
        class="ql-container ql-bubble py-2 bg-white border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
    />
</template>