<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import ActionSection from '@/Components/JetStream/ActionSection.vue';
import FileInput from '@/Components/Inputs/FileInput.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import TextareaWysiwyg from '@/Components/Inputs/TextareaWysiwyg.vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';

const form = useForm({
    _method: 'POST',
    name: '',
    logo: null,
    progress: null,
    description: '',
    is_active: true,
})

const { Success } = useFlashMessages( form );

const addNewBrand = () => {
    form.post(route('app_brand_store'), {
        forceFormData: true,
        onProgress: (progress) => {
            form.progress = Math.round((progress.loaded * 100) / progress.total);
        },
        onSuccess: () => {
            form.reset();
            form.progress = 0;

            Success('Brand added successfully');
        },
    });
}
</script>

<template>
    <Head title="Add brand"></Head>

    <action-section>
        <template #title>
            Add brand
        </template>

        <template #description>
            Add a new brand
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
                <input-label for="logo" value="Brand logo" />
                <file-input
                    id="logo"
                    v-model="form.logo"
                    type="file"
                    class="mt-1 block w-full"
                    required
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
        <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="addNewBrand">
                Save
        </primary-button>
    </div>
</template>

<script>
export default { 
    layout: Layout 
};
</script>