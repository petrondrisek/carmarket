<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AuthenticationCard from '@/Modules/JetStream/AuthenticationCard.vue';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';

import Layout from '@/Layouts/Layout.vue';
import { LineInput, Checkbox } from '@/Modules/Inputs';
import { PrimaryButton } from '@/Shared/Components';

const props = defineProps<{
    canResetPassword: boolean,
    status: string | null,
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
    errors: {
        email: '',
        password: '',
    }
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in"></Head>

    <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-center">Sign in</h2>
    <p class="text-center text-gray-400 mt-2">Don't have an account? <Link :href="route('register')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Register</Link></p>

    <AuthenticationCard>
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

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <LineInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password ?? ''" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="props.canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                </Link>

                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>