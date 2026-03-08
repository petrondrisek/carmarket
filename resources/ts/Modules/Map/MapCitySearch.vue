<script setup lang="ts">
import { onMounted, ref, useTemplateRef, watch } from 'vue';
import LineInput from '@/Modules/Inputs/LineInput.vue';
import { useClickOutside, useFetch } from '@/Shared/Composables';
import { City } from './map.models';

const city = defineModel<string>({ default: '' });
const props = defineProps<{ initialCity?: string }>();
const emit = defineEmits<{ (e: 'city-found', lat: number, lng: number): void }>();

const url = ref<string | null>(null);
const { data: cities, error, loading } = useFetch<City[]>(url, {});

watch(city, (newVal) => {
    if (newVal.length < 3) {
        url.value = null;
        cities.value = null;
        return;
    }
    
    url.value = "/api/search/city?alias=" + encodeURIComponent(newVal);
}, { flush: 'sync' }); // flush = to force immediate execution, right after city.value is reset (to prevent race conditions).

const setCityWithoutSearch = (name: string) => {
    city.value = name;
    url.value = null; 
    cities.value = null;
};

const selectCity = (result: City) => {
    city.value = result.city; 
    url.value = null;
    cities.value = null;
    emit('city-found', result.lat, result.lng);
};

defineExpose({
    setCityWithoutSearch
});

onMounted(() => {
    if (props.initialCity) {
        setCityWithoutSearch(props.initialCity);
    }
});

const citiesListRef = useTemplateRef('citiesListRef');
useClickOutside([citiesListRef], () => cities.value = null);
</script>

<template>
    <div class="relative w-full">
        <LineInput
            v-bind="$attrs" 
            v-model="city"
            prefix="📍"
            id="city" 
            type="text" 
            class="mb-2 block w-full" 
            autocomplete="off" 
        />

        <div v-if="error" class="text-red-500 text-sm mt-2">
            {{ error }}
        </div>

        <div 
            ref="citiesListRef"
            v-if="cities && cities?.data.length > 0" 
            class="absolute z-50 w-full max-h-40 overflow-y-auto bg-white dark:bg-gray-900 border dark:border-gray-700 shadow-lg rounded-b"
        >
            <ul>
                <li
                    v-for="c in cities.data" 
                    :key="`${c.city}-${c.lat}-${c.lng}`" 
                    @click="selectCity(c)"
                    class="cursor-pointer px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 border-b dark:border-gray-700 last:border-0"
                >
                    <span class="font-medium">{{ c.city }}</span>
                    <span class="text-xs text-gray-500 ml-2">{{ c.state }}</span>
                </li>
            </ul>
        </div>
        
        <div v-if="loading" class="absolute right-3 top-3">
             <div class="animate-spin h-4 w-4 border-2 border-primary-500 border-t-transparent rounded-full"></div>
        </div>
    </div>
</template>