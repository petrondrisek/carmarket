<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { hasUserPermission, UserPermission, User } from '@/Modules/JetStream';
import { ActionPanel, PrimaryButton } from '@/Shared/Components';
import CarDelete from './CarDelete.vue';
import CarMarkAsSold from './CarMarkAsSold.vue';
import { Car } from './car.models';

const { user, car } = defineProps<{
    user: User | null
    car: Car
}>();

const hasAccess = user !== null && (hasUserPermission(user, UserPermission.CAR) || user.email == car?.user.email);
const hasAdminAccess = user !== null && hasUserPermission(user, UserPermission.CAR);
</script>

<template>
    <ActionPanel v-if="user">
        <CarMarkAsSold :hasAccess="hasAccess" :car="car" />

        <PrimaryButton 
            v-if="hasAdminAccess" 
            as="button"
            @click="() => router.visit(route('app_car_edit', { car: car.id }))"
        >
            Edit car
        </PrimaryButton>
        
        <CarDelete :hasAccess="hasAdminAccess" :car="car" />
    </ActionPanel>
</template>