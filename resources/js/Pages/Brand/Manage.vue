<script setup>
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import SecondaryButton from '@/Components/Forms/SecondaryButton.vue';
import DialogModal from '@/Components/Modal/DialogModal.vue';
import LoadMorePagination from '@/Components/Pagination/LoadMorePagination.vue';
import Layout from '@/Layouts/Layout.vue';
import { usePage, Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';

// Get
const page = usePage();
const brands = ref(page.props.brands?.data ?? []);

const filters = ref({
    page: page.props.brands?.current_page ?? 1
});

// Delete
const selectedBrand = ref(null);
const form = useForm();
const { Success } = useFlashMessages( form );

const deleteBrand = () => {
    form.delete(route('app_brand_delete', { brand: selectedBrand.value.id }), { 
        preserveScroll: true,
        onSuccess: () => {
            brands.value = brands.value.filter(brand => brand.id !== selectedBrand.value.id);
            
            Success('Brand deleted successfully');

            selectedBrand.value = null; 
        },
        onError: () => {
            selectedBrand.value = null;
        }
    });
}
</script>

<template>
    <Head title="Manage brands"></Head>

    <div class="flex items-center gap-2 justify-end my-2">
        <primary-button @click="() => router.visit(route('app_brand_add'))">Add brand</primary-button>
    </div>
    <table class="w-full border-2 border-gray-200 dark:border-gray-700">
        <thead>
            <tr>
                <th class="p-4 text-left text-gray-700 dark:text-gray-400">Name (Active: ✅ / ❌)</th>
                <th class="p-4 text-left text-gray-700 dark:text-gray-400">Cars added</th>
                <th class="p-4 text-left text-gray-700 dark:text-gray-400">Created at</th>
                <th class="p-4 text-left text-gray-700 dark:text-gray-400">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="brand in brands" :key="'brand_' + brand.id" class="border-y-2 border-gray-200 dark:border-gray-700">
                <td class="p-4 text-left">{{ brand.name }} {{ brand.is_active ? '✅' : '❌' }}</td>
                <td class="p-4 text-left">{{ brand.cars_count }}</td>
                <td class="p-4 text-left">{{ new Date(brand.created_at).toLocaleString() }}</td>
                <td class="p-4 text-left flex gap-2 flex-wrap">
                    <primary-button @click="() => router.visit(route('app_brand_edit', { id: brand.id }))">Edit</primary-button>
                    <primary-button as="button" @click="selectedBrand = brand">Delete</primary-button>
                </td>
            </tr>
        </tbody>
    </table>

    <dialog-modal :show="selectedBrand">
        <template #title>
            Delete brand '{{ selectedBrand?.name }}'
        </template>

        <template #content>
            Are you sure you want to delete this brand?
        </template>

        <template #footer>
            <primary-button @click="deleteBrand">
                Delete
            </primary-button>
            <secondary-button @click="selectedBrand = null">
                Cancel
            </secondary-button>
        </template>
    </dialog-modal>

    <load-more-pagination 
        :store="brands" 
        model-name="brands" 
        :filters="filters" 
        get-route="app_brand_manage" 
        :starting-page="filters.page"
        :last-page="page.props.brands?.last_page ?? 1"
    />
</template>

<script>
export default { layout: Layout };
</script>