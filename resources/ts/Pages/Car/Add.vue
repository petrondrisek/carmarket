<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { useToast, ToastMessageType } from '@/Modules/Toast';
import { CarEngineType, CarStateType, CarTransmissionType } from '@/Modules/Car';
import { Form } from './Form';
import { CarForm } from './types';

const form = useForm<CarForm>({
    _method: 'POST',
    brand_id: null,
    model: '',
    color: '',
    kilometers: 0,
    location: {city: 'Pardubice', lat: 50.0158, lng: 15.7402},
    price: 0,
    engine: 'diesel' as CarEngineType,
    state: 'new' as CarStateType,
    transmission: 'manual' as CarTransmissionType,
    year: new Date().getFullYear().toString(),
    images: [],
    images_to_upload: [],
    images_to_delete: [],
    other_features: {},
    description: 'Bez popisu',
    fuel_consumption: 5.0
})

const { addToastMessage } = useToast();

const onSuccess = () => {
    addToastMessage('Car added successfully.', ToastMessageType.SUCCESS, 3000);
}
</script>

<template>
    <Head title="Add car"></Head>

    <Form 
        :form="form" 
        title="Add new car" 
        url="app_car_store"
        @success="onSuccess" 
    ></Form>
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>