<script setup lang="ts">
import { useTemplateRef } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AuthenticationCard from '@/Modules/JetStream/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Modules/JetStream/AuthenticationCardLogo.vue';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';

import { LineInput } from '@/Modules/Inputs';
import { PrimaryButton } from '@/Shared/Components';

const form = useForm({
    password: '',
    errors: {
        password: '',
    }
});

const passwordInput = useTemplateRef('passwordInput');

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value?.focus();
        },
    });
};
</script>

<template>
    <Head title="Secure Area" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" />
                <LineInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password ?? ''" />
            </div>

            <div class="flex justify-end mt-4">
                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
