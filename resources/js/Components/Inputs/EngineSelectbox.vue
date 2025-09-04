<script setup>
import { computed } from 'vue';
import Selectbox from '@/Components/Inputs/Selectbox.vue';

const props = defineProps({
    modelValue: {type: String, default: 'diesel'},
});

const emit = defineEmits([
    'update:modelValue'
]);

const engine = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
});
</script>

<template>
    <selectbox v-model="engine" class="w-full" id="engine">
        <template #options>
            <option value="diesel">Diesel</option>
            <option value="gasoline">Gasoline</option>
            <option value="hybrid">Hybrid</option>
            <option value="electric">Electric</option>
            <option value="lpg">LPG</option>
            <option value="cng">CNG</option>
        </template>
    </selectbox>
</template>