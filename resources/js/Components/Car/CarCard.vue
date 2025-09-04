<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    car: Object
});

</script>

<template>
    <div class="border rounded shadow bg-white dark:bg-gray-800 dark:border-gray-700">
        <img class="w-full object-cover" :style="{ height: '200px' }" :src="'/storage/' + props.car.images[0]" v-if="props.car.images.length > 0" :alt="props.car.name">
        
        <div class="w-full px-3">
            <Link 
            :href="route('app_car_show', props.car.id)"
            class="text-lg font-bold text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400"
            >
                {{ props.car.model }}
            </Link>

            <p class="text-sm text-gray-500">
                {{ props.car.brand.name }} &bull; {{ props.car.user.name }} &bull; {{ props.car.city_name }}
            </p>

            <p class="text-sm text-gray-500">
                {{ props.car.kilometers }} km &bull; {{ props.car.year }}
            </p>

            <p class="text-lg font-bold text-primary-500 dark:text-dark_primary-500">
                {{ props.car.price }} Kč
            </p>
        </div>
    </div>
</template>
