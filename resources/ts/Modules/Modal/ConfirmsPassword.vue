<script setup lang="ts">
import { ref, reactive, nextTick, useTemplateRef } from 'vue';
import { route } from 'ziggy-js';
import axios from 'axios';
import { LineInput } from '@/Modules/Inputs';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import { PrimaryButton, SecondaryButton } from '@/Shared/Components';
import Modal from './Modal.vue';

const modalRef = useTemplateRef('modalRef');

const emit = defineEmits<{
    (e: 'confirmed'): void;
}>();

interface Props {
    title?: string;
    content?: string;
    button?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Confirm Password',
    content: 'For your security, please confirm your password to continue.',
    button: 'Confirm',
});

const confirmingPassword = ref<boolean>(false);

interface FormState {
    password: string;
    error: string;
    processing: boolean;
}

const form = reactive<FormState>({
    password: '',
    error: '',
    processing: false,
});

const passwordInput = useTemplateRef('passwordInput');

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            confirmingPassword.value = true;

            modalRef.value?.show();

            setTimeout(() => passwordInput.value?.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        modalRef.value?.close();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value?.focus();
    });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = '';
    form.error = '';
};
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot></slot>
        </span>

        <Modal ref="modalRef" @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <LineInput
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        autocomplete="current-password"
                        @keyup.enter="confirmPassword"
                    />

                    <InputError :message="form.error ?? ''" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="modalRef?.close()">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="confirmPassword"
                >
                    {{ button }}
                </PrimaryButton>
            </template>
        </Modal>
    </span>
</template>
