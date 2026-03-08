<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { asset } from '@/Shared/Utils';
import type { Car } from './car.models';

const { car } = defineProps<{
    car: Car
}>();
</script>

<template>
    <div class="border rounded shadow bg-white dark:bg-gray-800 dark:border-gray-700">
        <img 
            v-if="car.images.length > 0" 
            class="w-full object-cover" 
            :style="{ height: '200px' }" 
            :src="asset(car.images[0])" 
            :alt="car.model">
        
        <div class="w-full px-3">
            <Link 
                :href="route('app_car_show', car.id)"
                class="text-lg font-bold text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400"
            >
                {{ car.model }}
            </Link>

            <p class="text-sm text-gray-500">
                {{ car.brand.name ?? "Unknown brand" }} &bull; {{ car.user?.name ?? "Unknown user" }} &bull; {{ car.location.city }}
            </p>

            <p class="text-sm text-gray-500">
                {{ car.kilometers.toLocaleString() }} km &bull; {{ car.year }}
            </p>

            <p class="text-lg font-bold text-primary-500 dark:text-dark_primary-500">
                {{ car.price.toLocaleString() }} Kč
            </p>
        </div>
    </div>
</template>
