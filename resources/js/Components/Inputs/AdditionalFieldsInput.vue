<script setup>
import { ref, computed } from 'vue';
import SecondaryButton from '../Forms/SecondaryButton.vue';
import TextInput from './TextInput.vue';

// Define
const props = defineProps({
    modelValue: {type: Object, default: {}},
});

const emit = defineEmits([
    'update:modelValue'
]);

// Ref
const value = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
}, { deep: true });

const addFieldName = ref('');

// Methods
const addField = (e) => {
    e.preventDefault();

    if(!addFieldName.value || !addFieldName.value.trim().length) return;

    let field_name = addFieldName.value.trim();

    let existing = Object.keys(value.value).find(field => field.name === field_name);
    if(existing) {
        alert(`Field '${field_name}' already exists`);
        return;
    }

    value.value[field_name] = '';
}

const removeField = (e, index) => {
    e.preventDefault();

    delete value.value[index];
}
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 border-b-2 border-gray-500 py-4">
        <div v-if="!Object.keys(value).length">
            <span class="block text-sm font-medium text-gray-400 dark:text-gray-200">No fields added</span>
        </div>

        <div v-for="(key, i) in Object.keys(value)" :key="`field_${i}`" class="col-span-2 lg:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                {{ key }}
            </label>

            <div class="flex items-center min-w-full">
                <TextInput v-model="value[key]"></TextInput>
                <button @click="(e) => removeField(e, key)" class="bg-gray-400 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition duration-150 ease-in-out cursor-pointer text-white px-3 py-1 ml-1">X</button>
            </div>
        </div>
    </div>
    
    <div class="flex items-center gap-2 justify-center pt-5">
        <TextInput v-model="addFieldName" @keydown.enter="addField" placeholder="Enter field name"></TextInput>
        <SecondaryButton @click="addField">Add field</SecondaryButton>
    </div>
</template>