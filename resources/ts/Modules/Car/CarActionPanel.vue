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
</script>

<template>
    <ActionPanel v-if="user">
        <CarMarkAsSold :user="user" :car="car" />

        <PrimaryButton 
            v-if="hasUserPermission(user, UserPermission.CAR)" 
            as="button"
            @click="() => router.visit(route('app_car_edit', { car: car.id }))"
        >
            Edit car
        </PrimaryButton>
        
        <CarDelete :user="user" :car="car" />
    </ActionPanel>
</template>