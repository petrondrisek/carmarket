<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AuthenticationCard from '@/Modules/JetStream/AuthenticationCard.vue';
import InputError from '@/Modules/JetStream/Forms/InputError.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';

import Layout from '@/Layouts/Layout.vue';
import { LineInput, Checkbox } from '@/Modules/Inputs';
import { PrimaryButton } from '@/Shared/Components';
import { PageProps } from '@/Shared/Types';

const page = usePage<PageProps>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    errors: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: '',
    }
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register"></Head>

    <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-center">Register</h2>

    <AuthenticationCard>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />
                <LineInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name ?? ''" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <LineInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
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
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password ?? ''" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <LineInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation ?? ''" />
            </div>

            <div v-if="page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ms-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms ?? ''" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Already registered?
                </Link>

                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
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