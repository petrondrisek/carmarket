<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head } from '@inertiajs/vue3';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});

const sectionClasses = "mb-4 bg-gray-200 dark:bg-gray-800 dark:text-gray-200 p-4 rounded";
</script>

<template>
    <Head title="Profile"></Head>
        
    <section v-if="$page.props.jetstream.canUpdateProfileInformation" :class="sectionClasses">
        <UpdateProfileInformationForm :user="$page.props.auth.user" />
    </section>

    <section v-if="$page.props.jetstream.canUpdatePassword" :class="sectionClasses">
        <UpdatePasswordForm class="mt-10 sm:mt-0" />
    </section>

    <section v-if="$page.props.jetstream.canManageTwoFactorAuthentication" :class="sectionClasses">
        <TwoFactorAuthenticationForm
            :requires-confirmation="confirmsTwoFactorAuthentication"
            class="mt-10 sm:mt-0"
        />
    </section>

    <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" :class="sectionClasses" />

    <section v-if="$page.props.jetstream.hasAccountDeletionFeatures" :class="sectionClasses">
        <DeleteUserForm class="mt-10 sm:mt-0" />
    </section>
</template>

<script>
export default {
    layout: Layout
}
</script>