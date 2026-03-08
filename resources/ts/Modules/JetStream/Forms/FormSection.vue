<script setup lang="ts">
import { computed, useSlots } from 'vue';
import SectionTitle from '@/Modules/JetStream/SectionTitle.vue';

const emit = defineEmits<{
    submitted: [event: Event],
}>();

const handleSubmit = (event: Event) => {
    event.preventDefault();
    emit('submitted', event);
};

const hasActions = computed<boolean>(() => !! useSlots().actions);
</script>

<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title"></slot>
            </template>
            <template #description>
                <slot name="description"></slot>
            </template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="handleSubmit">
                <div
                    class="px-4 py-5 sm:p-6"
                    :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                >
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form"></slot>
                    </div>
                </div>

                <div v-if="hasActions" class="flex items-center justify-end px-4 py-3 text-end sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>
