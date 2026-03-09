<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';
import { useFocus, watchDebounced } from '@vueuse/core';
import LineInput from '@/Modules/Inputs/LineInput.vue';
import { useClickOutside, useFetch } from '@/Shared/Composables';
import { City } from './map.models';

const lat = defineModel<number>('lat', { default: 50.032 });
const lng = defineModel<number>('lng', { default: 15.779 });
const city = defineModel<string>('city', { default: 'Pardubice' });

const url = ref<string | null>(null);
const { data: cities, error, loading } = useFetch<City[]>(url, {});

const inputRef = useTemplateRef<HTMLInputElement>('inputRef');
const { focused } = useFocus(inputRef);

watchDebounced(city, 
    (newVal: string) => {
        if (!focused.value || !newVal || newVal.length < 3) {
            url.value = null;
            cities.value = null;
            return;
        }

        execute(`/api/search/city?alias=${encodeURIComponent(newVal)}`);
    }, 
    { debounce: 300 }
);

const execute = (newUrl: string) => {
    url.value = newUrl;
    cities.value = null;
};

const selectCity = (result: City) => {
    city.value = result.city; 
    lng.value = result.lng;
    lat.value = result.lat;

    url.value = null;
    cities.value = null;
};

const citiesListRef = useTemplateRef('citiesListRef');
useClickOutside([citiesListRef], () => cities.value = null);
</script>

<template>
    <div class="relative w-full">
        <LineInput
            ref="inputRef"
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
             <div class="animate-spin h-4 w-4 border-2 border-primary-500 dark:border-dark_primary-400 border-t-transparent rounded-full"></div>
        </div>
    </div>
</template>