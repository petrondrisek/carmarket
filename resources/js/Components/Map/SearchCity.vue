<script setup>
import TextInput from '@/Components/Inputs/TextInput.vue';
import SearchCityResults from '@/Components/Map/SearchCityResults.vue';
import { ref, computed } from 'vue';

// define
const props = defineProps({
    modelValue: {type: {name: String, lat: Number, lng: Number}, default: {name: '', lat: 0, lng: 0}},
});

const emit = defineEmits([
    'update:modelValue',
    'changeMapLocation'
]);

// Refs
const citySearch = ref('');

const value = computed({
    get: () => props.modelValue,
    set: (val) => {
        if (props.modelValue !== val) {
            emit('update:modelValue', val);
        }
    }
});

// Methods
const clearCityName = (name) => {
    return name.replace(/([\w]+)\s?(\d+)?$/g, '$1');
}

const changeCity = (c) => {
    emit(
        'changeMapLocation', 
        Number(c.lat), 
        Number(c.lng),
        null,
        c.name
    );

    value.value = {name: clearCityName(c.name), lat: Number(c.lat), lng: Number(c.lng)};
}

const preventSearch = () => {
    citySearch.value = '';
}

// Expose
defineExpose({ preventSearch, clearCityName });
</script>

<template>
    <TextInput 
    @keydown.enter.prevent 
    @keydown.up.prevent 
    @keydown.down.prevent 
    v-on="$attrs"
    @input="citySearch = value.name" 
    v-model="value.name"
    prefix="📍"
    id="city" 
    type="text" 
    class="mb-2 block w-full" 
    required 
    autofocus 
    autocomplete="off" 
    />
    
    <SearchCityResults 
    :city="citySearch" 
    @city-selected="changeCity($event)"
    />

</template>

<script>
export default { inheritAttrs: false };
</script>