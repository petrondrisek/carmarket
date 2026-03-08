<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, useTemplateRef } from 'vue';

import Modal from '@/Modules/Modal/Modal.vue';
import { ToastMessageType } from '@/Modules/Toast/toast.models';
import { useToast } from '@/Modules/Toast/useToast';
import { PrimaryButton, SecondaryButton, Error } from '@/Shared/Components';
import { useProcessForm } from '@/Shared/Composables';
import { Brand } from './brand.models';

const { brand } = defineProps<{
    brand: Brand | null
}>();

const options = computed(() => ({brand: brand?.id }))

const emit = defineEmits<{
    (e: 'dismissed'): void,
    (e: 'deleted', brand: Brand): void
}>();

const modalRef = useTemplateRef('modalRef');

const form = useForm<Record<string, never>>({});
const { addToastMessage } = useToast();

const onSuccess = () => {
    const brandToDelete = brand;
    if (!brandToDelete) return;

    emit('deleted', brandToDelete);
    addToastMessage('Brand deleted successfully', ToastMessageType.SUCCESS, 3000);

    modalRef.value?.close();
}

const {
    process,
    error,
    processing
 } = useProcessForm(form, 'app_brand_delete', options, onSuccess, 'DELETE');

defineExpose({
    process: () => modalRef.value?.show()
})
</script>

<template>
    <Modal ref="modalRef" @close="emit('dismissed')">
        <template #title>
            Delete brand '{{ brand?.name }}'
        </template>

        <template #content>
            Are you sure you want to delete this brand?

            <Error :message="error" />
        </template>

        <template #footer>
            <PrimaryButton @click="process" :disabled="processing" :class="{ 'opacity-25': processing }">
                Delete
            </PrimaryButton>
            <SecondaryButton @click="modalRef?.close()">
                Cancel
            </SecondaryButton>
        </template>
    </Modal>
</template>