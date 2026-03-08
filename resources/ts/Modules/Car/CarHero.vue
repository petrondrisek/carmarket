<script setup lang="ts">
import { PageTitle, Money } from '@/Shared/Components';
import { useSafeHtml } from '@/Shared/Composables';
import { Car } from './car.models';

const { car } = defineProps<{
    car: Car
}>();

const description = useSafeHtml(car.description);
</script>

<template>
    <div class="shadow-md rounded-md bg-white dark:bg-gray-800 p-3">
        <div class="grid grid-cols-3 relative">
            <div class="gallery max-w-[100%] col-span-3 lg:col-span-2 relative">
                <slot name="gallery"></slot>
            </div>
        </div>

        <div class="base-info col-span-3 lg:col-span-1 p-4 grid grid-cols-1">
            <div class="base-info__header">
                <PageTitle>
                    {{ car.brand.name ?? 'Unknown brand' }} - {{ car.model ?? 'Unknown model' }}
                </PageTitle>
                <p>{{ car.kilometers }} km &bull; {{ car.year }} &bull; {{ car.location.city }}</p>
            </div>

            <p class="my-6 row-span-12">
                {{ description.slice(0, 200) }}
                {{ description.length > 200 ? '...' : '' }}
                <slot name="short-description"></slot>
            </p>
            
            <Money class="text-4xl text-right" :amount="car.price" />

            <slot name="buttons"></slot>
        </div>
    </div>
</template>

