<script setup>
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';

const loading = ref(true);
const brands = ref([{id: null, name: 'No brand selected', logo: null}]);
const selectedValue = ref(null);
const chooseShow = ref(false);

const props = defineProps({
    modelValue: {type: Number, default: null}
});

const emit = defineEmits([
    'update:modelValue'
]);

const value = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit('update:modelValue', value);

        selectedValue.value = brands.value.findIndex(brand => brand.id == value);
        chooseShow.value = false;
    }
});

const getBrands = async () => {
    try {
        const response = await axios.get('/api/brands');

        if (!response.data.success) {
            alert(response.data.message);
            return;
        }

        brands.value = [...brands.value, ...response.data.response];
        
        if(brands.value.length > 0 && !value.value)
        {
            selectedValue.value = 0;
            value.value = brands.value[0].id;
        } 

        else if(brands.value.length > 0){
            selectedValue.value = brands.value.findIndex(brand => brand.id == value.value);
        }
    } catch (error) {
        console.log(error);
    }

    loading.value = false;
}

const onKeyDown = (e) => {
    e.preventDefault();

    // Down / Right
    if(
        (e.key === 'ArrowDown' || e.key === 'ArrowRight') && 
        selectedValue.value + 1 < brands.value.length
    ) {
        selectedValue.value += 1;
        value.value = brands.value[selectedValue.value].id;
    }

    // Up / Left
    if((
        e.key === 'ArrowUp' || e.key === 'ArrowLeft') &&
        selectedValue.value > 0
    ) {
        selectedValue.value -= 1;
        value.value = brands.value[selectedValue.value].id; 
    }
}

onMounted(() => {
    getBrands();
})
</script>

<template>
    <div
        tabindex="0"
        @keydown="onKeyDown"
        @click="chooseShow = !chooseShow" 
        class="bg-white dark:bg-gray-900 rounded border-2 border-gray-300 dark:border-gray-700 p-2 relative cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800"
    >
        <span class="absolute right-0 top-0 m-2 text-gray-400">{{ chooseShow ? '&uarr;' : '&darr;' }}</span>
        <span v-if="loading">Loading...</span>

        <span v-if="brands.length === 0 && !loading">No brand selected</span>

        <span v-if="!loading && brands.length" class="flex items-center">
            <img v-if="brands[selectedValue].logo !== null" class="mx-1 size-7 rounded-full object-cover" :src="'/storage/' + brands[selectedValue].logo" :alt="brands[selectedValue].name">
            {{ brands[selectedValue].name }}
        </span>
    </div>
    <div v-show="chooseShow" class="bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded max-h-40 overflow-y-auto">
        <div 
        v-for="(brand, index) in brands" 
        :key="brand.id" 
        class="mt-1 rounded" 
        :class="{ 
            'bg-primary-500 dark:bg-dark_primary-500 text-white hover:bg-primary-500': index == selectedValue,
            'hover:bg-gray-200 dark:hover:bg-gray-600': index != selectedValue
        }"
        >
            <label :for="'brand-' + brand.id" class="flex p-2 cursor-pointer">
                <img v-if="brand.logo !== null" class="size-7 object-contain mr-1" :src="'/storage/' + brand.logo" :alt="brand.name">
                {{ brand.name }}
            </label>
            <input 
            v-model="value" 
            type="radio" 
            v-bind="$attrs"
            :id="'brand-' + brand.id" 
            :value="brand.id"
            class="hidden"
            >
        </div>
    </div>
</template>

<script>
export default { inheritAttrs: false };
</script>