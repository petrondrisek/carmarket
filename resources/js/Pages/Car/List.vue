<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import CarCard from '@/Components/Car/CarCard.vue';
import Layout from '@/Layouts/Layout.vue';
import LoadMorePagination from '@/Components/Pagination/LoadMorePagination.vue';

const q = new URLSearchParams(window.location.search).get('q') ?? '';
const props = usePage()?.props;
const cars = ref(props?.cars?.data ?? [])

const filters = ref(props.queryParams ?? {});
const filtersCount = computed(() => {
    return Object.keys(filters.value).filter(key => filters.value[key] !== null && key !== 'page').length;
});

onMounted(() => {
    if(!filters.value.page)
        filters.value.page = 1;
});
</script>

<template>
    <Head title="List of cars"></Head>

    <Link :href="route('app_search', { q })" class="text-white mt-8 p-2 px-8 rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
        Filter ({{ filtersCount }})
    </Link>

    <p v-if="cars.length === 0" class="my-8 text-center text-gray-600 dark:text-gray-400">No cars found</p>
    <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <car-card v-for="car in cars" :key="car.id" :car="car"></car-card>
    </div>

    <load-more-pagination 
        :store="cars" 
        model-name="cars" 
        :filters="filters" 
        get-route="app_car_get" 
        :starting-page="props?.cars?.current_page ?? 1"
        :last-page="props?.cars?.last_page ?? 1"
        :base64="true" />
</template>

<script>
export default { 
    layout: Layout 
};
</script>