<script setup>
import { watch, ref, onBeforeUnmount, onMounted, onUnmounted } from 'vue';
import { debounce } from 'lodash';
import axios from 'axios';

// Define
const props = defineProps({
    city: String
});

const emit = defineEmits([
    'city-selected'
]);

// Refs
const blockSearchAfterSelect = ref(false);
const loading = ref(false);
const activeIndex = ref(-1);
const cities = ref([]);
const listItemRef = ref([]);

// Search
const apiCall = async(city) => {
    activeIndex.value = -1;
    listItemRef.value = [];

    if(!city || city.length < 3) {
        cities.value = [];
        return;
    }

    // Prevent searching after selecting option in whisperer.
    if(!blockSearchAfterSelect.value) {
        loading.value = true;
        try {
            const response = await axios.get(`/api/search-by-city/${city}`);

            if (!response.data.success) {
                cities.value = [];
                alert(response.data.message);
                loading.value = false;
                return;
            }
            
            cities.value = response.data.response;
        } catch (error) {
            cities.value = [];
            alert(error.response.data.message); 
        } finally {
            loading.value = false;
            blockSearchAfterSelect.value = false;
        }
    }
    
}

const search = debounce(apiCall, 1000);

// Auto detect changes in props
watch(() => props.city, (val) => {
   search(val);
});

// Parse selected city to parent
const changeCity = (city) => {
    emit('city-selected', city);
    cities.value = [];
}

// Key events
const onKeyDown = (e) => {
    if(loading.value) return;

    if(e.key === 'Enter' && activeIndex.value > -1 && cities.value.length > 0) {
        e.preventDefault();
        changeCity(cities.value[activeIndex.value]);
    }

    if(e.key === 'ArrowDown' && cities.value.length > 0) {
        e.preventDefault();
        activeIndex.value = activeIndex.value === cities.value.length - 1 ? 0 : activeIndex.value + 1;
    
        let el = listItemRef.value[activeIndex.value];
        el.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
    }

    if(e.key === 'ArrowUp' && cities.value.length > 0) {
        e.preventDefault();
        activeIndex.value = activeIndex.value === 0 ? cities.value.length - 1 : activeIndex.value - 1;
    
        let el = listItemRef.value[activeIndex.value];
        el.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
    }

    if(e.key === 'Escape' && cities.value.length > 0) {
        e.preventDefault();
        cities.value = [];
    }
}

onMounted(() => {
    window.addEventListener('keydown', onKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', onKeyDown);
});

onBeforeUnmount(() => {
  search.cancel();
});
</script>
<template>
    <div tabindex="0" @keydown="onKeyDown" class="max-h-40 overflow-y-scroll bg-gray-200 dark:bg-gray-800">
        <div v-if="loading" class="text-center p-2">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600 mx-auto" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" class="fill-gray-300 dark:fill-gray-600"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" class="fill-primary-600 dark:fill-dark_primary-600"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
        <ul v-else>
            <li
            v-for="(c, i) in cities" 
            :ref="(el) => listItemRef[i] = el"
            :key="c.id" 
            @click="changeCity(c)"
            class="cursor-pointer px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-700"
            :class="{ 'bg-gray-300 dark:bg-gray-700': activeIndex === i }"
            >
                {{ c.name }} - {{ c.state }}
            </li>
        </ul>
    </div>
</template>