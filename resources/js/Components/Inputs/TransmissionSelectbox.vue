<script setup>
import { computed } from 'vue';
import Selectbox from './Selectbox.vue';

const props = defineProps({
    modelValue: {type: String, default: 'automatic'},
});

const emit = defineEmits([
    'update:modelValue'
]);

const transmission = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
    }
})
</script>

<template>
    <selectbox v-model="transmission" id="transmission" class="w-full">
        <template #options>
            <option value="automatic">Automatic</option>
            <option value="manual">Manual</option>
        </template>
    </selectbox>
</template>