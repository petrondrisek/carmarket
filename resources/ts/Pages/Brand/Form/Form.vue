<script setup lang="ts">
import { computed } from 'vue';
import { Page } from '@inertiajs/core';
import { BrandForm } from '@/Pages/Brand/types';
import { PageProps } from '@/Shared/Types/PageProps';

// Components
import ActionSection from '@/Modules/JetStream/ActionSection.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';
import { 
    TextareaInput as TextareaWysiwyg,
    LineInput,
    ImageInput,
    Checkbox
 } from '@/Modules/Inputs'
import { PrimaryButton, Error } from '@/Shared/Components';
import { useBrandForm } from './useBrandForm';

const props = defineProps<{
    title: string,
    form: BrandForm,
    url: string
    options?: Record<string, any>,
}>();

const emit = defineEmits<{
    (e: 'success', page: Page<PageProps>): void
}>();

const { form, error, processing, submit } = useBrandForm(props, emit);

const logoComp = computed({
    get: () => {
        if (!form.logo) return [];
        return (Array.isArray(form.logo) ? form.logo : [form.logo]) as File[];
    },
    set: (newValue) => form.logo = newValue as File[]
});

defineExpose({
    form: props.form
})
</script>

<template>
    <ActionSection>
        <template #title>
            {{props.title}}
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="brand" value="Brand name" />
                <LineInput
                    id="brand"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                    />
            </div>

            <div class="mb-2">
                <InputLabel for="logo" value="Brand logo" />
                
                <slot name="images"></slot>
                
                <ImageInput
                    v-model="logoComp"
                    :images="form.logo ? [form.logo] : []"
                    :max-images="1"
                />
            </div>

            <div class="mb-2 flex flex-wrap gap-1">
                <Checkbox v-model:checked="form.is_active" class="mr-2" />
                <InputLabel for="is_active" value="Should be brand active (means it will be visible)." class="inline" />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Description
        </template>

        <template #description>
            Add some interesting information about this brand.
        </template>

        <template #content>
            <div class="mb-2">
                <TextareaWysiwyg v-model="form.description" />
            </div>
        </template>
    </ActionSection>

    <Error :message="error" />

    <div class="flex items-center justify-end my-4">
        <PrimaryButton
            :class="{ 'opacity-25': processing }" 
            :disabled="processing" 
            @click="submit"
        >
                Save
        </PrimaryButton>
    </div>
</template>