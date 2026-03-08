<script setup lang="ts">
import SectionTitle from '@/Modules/JetStream/SectionTitle.vue';
</script>

<template>
    <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded mb-2 md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 sm:p-6 sm:rounded-lg">
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
