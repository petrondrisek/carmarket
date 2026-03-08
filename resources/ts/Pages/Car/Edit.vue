<script setup lang="ts">
import { Head, usePage, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { useToast, ToastMessageType } from '@/Modules/Toast';
import { PageProps } from '@/Shared/Types';
import { Form } from './Form';
import { CarForm } from './types';

const page = usePage<PageProps>();
const car = page.props.car?.data ?? null;

const form = useForm<CarForm>({
    _method: 'POST',
    brand_id: car.value.brand?.id ?? 0,
    model: car.value.model ?? '',
    color: car.value.color ?? '',
    kilometers: car.value.kilometers,
    location: {
        city: car.value.location.city ?? 'Pardubice', 
        lat: car.value.location.lat ?? 50.0158, 
        lng: car.value.location.lng ?? 15.7402
    },
    price: car.value.price,
    engine: car.value.engine ?? 'diesel',
    state: car.value.state ?? 'new',
    transmission: car.value.transmission ?? 'manual',
    year: car.value.year ?? new Date().getFullYear().toString(),
    images: car.value.images ?? [],
    other_features: car.value.other_features ?? {},
    description: car.value.description ?? 'Bez popisu',
    fuel_consumption: car.value.fuel_consumption,
    images_to_upload: [],
    images_to_delete: []
})
const { addToastMessage } = useToast();

const onSuccess = () => {
    addToastMessage('Car edit successfully', ToastMessageType.SUCCESS, 3000);
}
</script>

<template>
    <Head :title="`${car.model ?? 'X'} - Edit car`"></Head>

    <Form
        :form="form"
        :title="`${car.model ?? 'X'} - Edit car`"
        url="app_car_save"
        :options="{ car: car.id }"
        @success="onSuccess"
    ></Form>    
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>