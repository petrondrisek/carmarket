<script setup lang="ts">
import { Head, usePage, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Layout from '@/Layouts/Layout.vue';
import { CarCard } from '@/Modules/Car';
import { ParticleSection, SubTitle } from '@/Shared/Components';
import { PageProps } from '@/Shared/Types';

const page = usePage<PageProps>();
const cars = page.props.cars?.data ?? [];
</script>

<template>
    <Head title="Dashboard"></Head>
    <ParticleSection>
        <div class="text-5xl flex justify-center items-center flex-col">
            <div class="w-full">Choose your</div>
            <div class="w-full text-primary-600 font-extrabold dark:text-dark_primary-600 text-right">
                dream car
            </div>
            <Link :href="route('app_car_search')" class="text-white mt-8 p-2 px-8 text-xl rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
                Find the best offer
            </Link>
        </div>
    </ParticleSection>

    <SubTitle class="text-center">Latest cars</SubTitle>
    <div class="my-6 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <CarCard v-for="car in cars" :key="car.id" :car="car"></CarCard>
    </div>

    <Link :href="route('app_car_get')" class="text-white block w-max mb-8 mx-auto p-2 px-8 text-xl rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
        See all cars
    </Link>
</template>

<script lang="ts">
export default {
    layout: Layout,
}
</script>