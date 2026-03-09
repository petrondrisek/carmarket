<script setup lang="ts">
import { computed, ref } from 'vue';
import { SecondaryButton } from '@/Shared/Components';
import LineInput from '@/Modules/Inputs/LineInput.vue';

const model = defineModel<Record<string, string>>({
    default: () => ({})
});

const addFieldName = ref<string>('');

const hasFields = computed(
  () => Object.keys(model.value).length > 0
);

const addField = (e?: Event) => {
    e?.preventDefault();

    const fieldName = addFieldName.value.trim();
    if(!fieldName) return;

    if (Object.prototype.hasOwnProperty.call(model.value, fieldName)) {
        alert(`Field '${fieldName}' already exists`);
        return;
    }

    model.value = {
        ...model.value,
        [fieldName]: ''
    };

    addFieldName.value = '';
}

const removeField = (e: Event, key: string) => {
    e.preventDefault();

    const { [key]: _, ...rest } = model.value;
    model.value = rest;
}
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 border-b-2 border-gray-500 py-4">
        <div v-if="!hasFields">
            <span class="block text-sm font-medium text-gray-400 dark:text-gray-200">No fields added</span>
        </div>

        <div v-for="(key, i) in Object.keys(model)" :key="`field_${i}`" class="col-span-2 lg:col-span-1">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                {{ key }}
            </label>

            <div class="flex items-center min-w-full">
                <LineInput v-model="model[key]"/>
                <button 
                    @click="(e) => removeField(e, key as string)" 
                    class="bg-gray-400 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition duration-150 ease-in-out cursor-pointer text-white px-3 py-1 ml-1"
                    title="Remove field"
                >
                    X
                </button>
            </div>
        </div>
    </div>
    
    <div class="flex items-center gap-2 justify-center pt-5">
        <LineInput v-model="addFieldName" @keydown.enter="addField" placeholder="Enter field name" />
        <SecondaryButton @click="addField">Add field</SecondaryButton>
    </div>
</template>