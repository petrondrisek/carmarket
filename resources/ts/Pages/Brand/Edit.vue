<script setup lang="ts">
import { Page } from '@inertiajs/core';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { useToast, ToastMessageType } from '@/Modules/Toast';
import { asset } from '@/Shared/Utils';
import { PageProps } from '@/Shared/Types';
import { Form } from './Form';
import { BrandForm } from './types';

const page = usePage<PageProps>();
const { brand } = page.props;

const form = useForm<BrandForm>({
    _method: 'POST',
    name: brand.value?.name ?? '',
    logo: [],
    description: brand.value?.description ?? '',
    is_active: !!brand.value?.is_active,
});

const { addToastMessage } = useToast();

const onSuccess = (_: Page<PageProps>) => {
    addToastMessage('Brand edited successfully.', ToastMessageType.SUCCESS, 3000);
};
</script>

<template>
    <Head :title="'Edit brand'"></Head>

    <div v-if="brand === null">
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Error: Brand not found.</span>
        </div>
    </div>

    <Form 
        v-if="brand !== null"
        :form="form" 
        :title="`Editing brand - ${brand.name}`" 
        url="app_brand_save" 
        :options="{ brand: brand.id }"
        @success="onSuccess" 
    >
        <template #images>
            <p>
                <strong>Current image:</strong>
            </p>

            <img 
                v-if="brand.logo" 
                :src="asset(brand.logo)" 
                :alt="brand.name" 
                :style="{ height: '120px' }" 
                class="mb-4"
            />
            <p v-else>No image yet.</p>
        </template>
    </Form>
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>