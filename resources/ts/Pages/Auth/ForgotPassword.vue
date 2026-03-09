<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AuthenticationCard from '@/Modules/JetStream/AuthenticationCard.vue';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';

import Layout from '@/Layouts/Layout.vue';
import { LineInput } from '@/Modules/Inputs';
import { PrimaryButton } from '@/Shared/Components';

const props = defineProps<{
    status: string | null,
}>();

const form = useForm({
    email: '',
    errors: {
        email: '',
    }
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password"></Head>

    <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-center">Forgot password</h2>

    <AuthenticationCard>
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="props.status" class="mb-4 font-medium text-sm text-green-600">
            {{ props.status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <LineInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email ?? ''" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>

<script lang="ts">
export default { layout: Layout };
</script>
