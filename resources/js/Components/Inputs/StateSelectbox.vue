<script setup>
import { computed } from 'vue';
import Selectbox from './Selectbox.vue';

const props = defineProps({
    modelValue: {type: String, default: ''},
});

const emit = defineEmits([
    'update:modelValue'
]);

const state = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
});
</script>

<template>
    <selectbox v-model="state" class="w-full" id="state">
        <template #options>
            <option value="new">New</option>
            <option value="used">Used</option>
            <option value="refurbished">Refurbished</option>
        </template>
    </selectbox>
</template>