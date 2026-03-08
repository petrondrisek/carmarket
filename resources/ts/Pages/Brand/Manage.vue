<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';
import { usePage, Head, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Layout from '@/Layouts/Layout.vue';
import { LoadMorePagination } from '@/Modules/Pagination';
import { BrandDelete, type Brand } from '@/Modules/Brand';
import { PageProps } from '@/Shared/Types';
import { ActionPanel, Table, TableTd, PrimaryButton } from '@/Shared/Components';

// Get
const page = usePage<PageProps>();
const brands = page.props.brands?.data ?? [];

// Delete
const deleteRef = useTemplateRef('deleteRef');
const selectedBrand = ref<Brand | null>(null);

const requestDelete = (brand: Brand) => {
    selectedBrand.value = brand;
    deleteRef.value?.process();
};
</script>

<template>
    <Head title="Manage brands"></Head>

    <ActionPanel>
        <PrimaryButton @click="() => router.visit(route('app_brand_add'))">Add brand</PrimaryButton>
    </ActionPanel>

    <Table :headers="['Name (Active: ✅ / ❌)', 'Cars added', 'Created at', 'Actions']">
        <tr v-for="brand in brands" :key="'brand_' + brand.id" class="border-y-2 border-gray-200 dark:border-gray-700">
            <TableTd>{{ brand.name }} {{ brand.is_active ? '✅' : '❌' }}</TableTd>
            
            <TableTd>{{ brand.stats.total_cars }}</TableTd>
            
            <TableTd>{{ new Date(brand.created_at).toLocaleString() }}</TableTd>
            
            <TableTd class="flex gap-2 flex-wrap">
                <PrimaryButton @click="() => router.visit(route('app_brand_edit', { id: brand.id }))">Edit</PrimaryButton>
                <PrimaryButton as="button" @click="() => requestDelete(brand)">Delete</PrimaryButton>
            </TableTd>
        </tr>
    </Table>

    <BrandDelete
        :brand="selectedBrand" 
        ref="deleteRef" 
        @dismissed="selectedBrand = null"
        @deleted="(brand) => brands = brands.filter(b => b.id !== brand.id)" />

    <LoadMorePagination
        model-name="brands" 
        get-route="app_brand_manage" 
        :starting-page="1"
        :last-page="page.props.brands?.meta.last_page ?? 1"
        :per-page="page.props.brands?.meta.per_page"
        @loaded="(items) => brands.push(...items)"
    />
</template>

<script lang="ts">
export default { layout: Layout };
</script>