<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Layout from '@/Layouts/Layout.vue';
import { CarCard } from '@/Modules/Car';
import { LoadMorePagination } from '@/Modules/Pagination';
import { Error } from '@/Shared/Components';
import { PageProps } from '@/Shared/Types';
import { useCarSearch } from './Search/useCarSearch';
import { FiltersExtended, FiltersExtendedFree } from './Search/types';

const props = usePage<PageProps>()?.props;
const cars = props?.cars?.data ?? [];

const filters = ref<FiltersExtended>(props.queryParams ?? {} as FiltersExtended);
const filtersCount = computed(() => Object.keys(filters.value).length);

const { mapToQuery } = useCarSearch({} as FiltersExtendedFree);
const query = computed(() => mapToQuery(filters.value));
</script>

<template>
    <Head title="List of cars"></Head>

    <Link :href="route('app_car_search', query as any)" class="text-white mt-8 p-2 px-8 rounded bg-primary-600 hover:bg-primary-500 dark:bg-dark_primary-600 dark:hover:bg-dark_primary-500">
        Filter ({{ filtersCount }})
    </Link>

    <Error v-if="cars.length === 0" message="No cars found" />

    <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <CarCard v-for="car in cars" :key="car.id" :car="car"/>
    </div>

    <LoadMorePagination
        model-name="cars" 
        get-route="app_car_get" 
        :starting-page="props?.cars?.meta.current_page ?? 1"
        :last-page="props?.cars?.meta.last_page ?? 1"
        :per-page="props?.cars?.meta.per_page ?? 1"
        :filters="query"
        @loaded="(items) => cars.push(...items)"
    />
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>