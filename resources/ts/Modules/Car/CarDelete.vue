<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { useTemplateRef } from 'vue';
import { hasUserPermission, UserPermission, User } from '@/Modules/JetStream';
import { ToastMessageType } from '@/Modules/Toast/toast.models';
import { useToast } from '@/Modules/Toast/useToast';
import Modal from '@/Modules/Modal/Modal.vue';
import { PrimaryButton, SecondaryButton } from '@/Shared/Components';
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
    const carToDelete = car;
    if (!carToDelete) return;

    addToastMessage('Car deleted successfully', ToastMessageType.SUCCESS, 3000);
    router.visit(route('app_car_list'));

    modalRef.value?.close();
}

const {
    process,
    error,
    processing
 } = useProcessForm(form, 'app_car_delete', { car: car?.id }, onSuccess, 'DELETE');
</script>

<template>
    <PrimaryButton 
        v-if="user && hasUserPermission(user, UserPermission.CAR)" 
        as="button" 
        @click="modalRef?.show()"
    >
        Delete car
    </PrimaryButton>
    
    <Modal 
        v-if="user && hasUserPermission(user, UserPermission.CAR)" 
        ref="modalRef"
    >
        <template #title>Delete car</template>

        <template #content>
            <p>Are you sure you want to delete this car?</p>
        
            <p v-if="error" class="text-red-800">
                {{ error }}
            </p>
        </template>

        <template #footer>
            <PrimaryButton @click="process" :disabled="processing">Delete</PrimaryButton>
            <SecondaryButton @click="modalRef?.close();">Cancel</SecondaryButton>
        </template>
    </Modal>
</template>