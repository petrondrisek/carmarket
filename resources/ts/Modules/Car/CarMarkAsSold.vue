<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { useTemplateRef } from 'vue';
import { ToastMessageType } from '@/Modules/Toast/toast.models';
import { useToast } from '@/Modules/Toast/useToast';
import Modal from '@/Modules/Modal/Modal.vue';
import { hasUserPermission, UserPermission, User } from '@/Modules/JetStream';
import { PrimaryButton, SecondaryButton, Error } from '@/Shared/Components';
import { useProcessForm } from '@/Shared/Composables';
import { Car } from './car.models';

const { car, user } = defineProps<{
    car: Car | null,
    user: User | null
}>();

const modalRef = useTemplateRef('modalRef');

const form = useForm<any>({});
const { addToastMessage } = useToast();

const onSuccess = () => {
    const carToMarkAsSold = car;
    if (!carToMarkAsSold) return;

    addToastMessage('Car marked as sold successfully', ToastMessageType.SUCCESS, 3000);
    router.visit(route('app_car_list'));

    modalRef.value?.close();
}

const {
    process,
    error,
    processing
 } = useProcessForm(form, 'app_car_sold', { car: car?.id }, onSuccess, 'POST');
</script>

<template>
    <PrimaryButton 
        v-if="!car?.is_sold && user && (hasUserPermission(user, UserPermission.CAR) || user.id == car?.user.id)" 
        as="button" 
        @click="modalRef?.show()"
    >
        Mark as sold
    </PrimaryButton>
    
    <Modal 
        v-if="user && hasUserPermission(user, UserPermission.CAR)" 
        ref="modalRef"
    >
        <template #title>Mark as sold</template>

        <template #content>
            <p>Are you sure you want to mark this car as sold?</p>
        
            <Error :message="error" />
        </template>

        <template #footer>
            <PrimaryButton @click="process" :disabled="processing">Confirm</PrimaryButton>
            <SecondaryButton @click="modalRef?.close();">Cancel</SecondaryButton>
        </template>
    </Modal>
</template>