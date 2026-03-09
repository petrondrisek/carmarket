<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import ActionMessage from '@/Modules/JetStream/Forms/ActionMessage.vue';
import FormSection from '@/Modules/JetStream/Forms/FormSection.vue';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';

import { LineInput } from '@/Modules/Inputs';
import { PrimaryButton } from '@/Shared/Components';

const passwordInput = useTemplateRef('passwordInput');
const currentPasswordInput = useTemplateRef('currentPasswordInput');

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
    errors: {
        current_password: '',
        password: '',
        password_confirmation: '',
    }
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="current_password" value="Current Password" />
                <LineInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password ?? ''" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="password" value="New Password" />
                <LineInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password ?? ''" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <LineInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation ?? ''" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
