<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import { Page } from '@inertiajs/core';
import Layout from '@/Layouts/Layout.vue';
import { useToast, ToastMessageType } from '@/Modules/Toast';
import { PageProps } from '@/Shared/Types';
import { Form } from './Form'
import { BrandForm } from './types';

const form = useForm<BrandForm>({
    _method: 'POST',
    name: '',
    logo: null,
    progress: null,
    description: '',
    is_active: true,
})

const { addToastMessage } = useToast();

const onSuccess = (_: Page<PageProps>) => {
    addToastMessage('Brand added successfully.', ToastMessageType.SUCCESS, 3000);
}

</script>

<template>
    <Head title="Add brand"></Head>

    <Form 
        :form="form" 
        title="Add new brand" 
        url="app_brand_store"
        @success="onSuccess" 
    ></Form>
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>