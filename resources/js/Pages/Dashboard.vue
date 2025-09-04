<script setup>
import { ref } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';
import ParticleSection from '@/Components/ParticleSection/ParticleSection.vue';
import CarCard from '@/Components/Car/CarCard.vue';

const page = usePage();
useFlashMessages( page.props );

const cars = ref(page.props.cars?.data ?? []);
</script>

<template>
    <Head title="Dashboard"></Head>
    <particle-section>
        <div class="text-5xl flex justify-center items-center flex-col">
            <div class="w-full">Choose your</div>
            <div class="w-full text-primary-600 font-extrabold dark:text-dark_primary-600 text-right">
                dream car
            </div>
            <Link :href="route('app_search')" class="text-white mt-8 p-2 px-8 text-xl rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
                Find the best offer
            </Link>
        </div>
    </particle-section>

    <h2 class="mt-8 text-2xl font-semibold text-center">Latest cars</h2>
    <div class="my-6 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <car-card v-for="car in cars" :key="car.id" :car="car"></car-card>
    </div>
    <Link :href="route('app_car_get')" class="text-white block w-max mb-8 mx-auto p-2 px-8 text-xl rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
        See all cars
    </Link>
</template>

<script>
export default {
    layout: Layout,
}
</script>