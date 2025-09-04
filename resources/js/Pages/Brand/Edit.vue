<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import ActionSection from '@/Components/JetStream/ActionSection.vue';
import FileInput from '@/Components/Inputs/FileInput.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import TextareaWysiwyg from '@/Components/Inputs/TextareaWysiwyg.vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';
import { ref } from 'vue';

const page = usePage();
const brand = ref(page?.props.brand ?? {});

const form = useForm({
    _method: 'POST',
    name: brand.value.name ?? '',
    logo: null,
    description: brand.value.description ?? '',
    is_active: brand.value.is_active === 1 ?? false,
});

const { Success } = useFlashMessages( form );

const editBrand = () => {
    form.post(route('app_brand_save', { brand: brand.value.id }), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            form.progress = 0;

            Success('Brand edited successfully.');
        },
    });
}
</script>

<template>
    <Head :title="`${brand.name ?? 'X'} - Edit brand`"></Head>

    <action-section>
        <template #title>
            Edit brand
        </template>

        <template #description>
            Editing brand {{ brand.name ?? 'X' }}
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="brand" value="Brand name" />
                <text-input
                    id="brand"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="name"
                    />
            </div>

            <div class="mb-2">
                <img v-if="brand.logo !== null" class="size-7 object-contain mr-1" :src="'/storage/' + brand.logo" :alt="brand.name">
                <input-label for="logo" value="Brand logo" />
                <file-input
                    id="logo"
                    v-model="form.logo"
                    type="file"
                    class="mt-1 block w-full"
                    />
            </div>

            <div class="mb-2">
                <Checkbox v-model:checked="form.is_active" class="inline mr-2" />
                <input-label for="is_active" value="Should be brand active (means it will be visible)." class="inline" />
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Description
        </template>

        <template #description>
            Add some interesting information about this brand.
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="desciption" value="Description" />
                <textarea-wysiwyg v-model="form.description" />
            </div>
        </template>
    </action-section>

    <div class="flex items-center justify-end my-4">
        <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="editBrand">
                Save
        </primary-button>
    </div>
</template>

<script>
export default { 
    layout: Layout 
};
</script>