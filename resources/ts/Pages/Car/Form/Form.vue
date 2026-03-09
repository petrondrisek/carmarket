<script setup lang="ts">
import { Page } from '@inertiajs/core';
import { PageProps } from '@/Shared/Types';
import { PrimaryButton, Error } from '@/Shared/Components';
import { CarForm } from '../types';

// Comp
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';
import ActionSection from '@/Modules/JetStream/ActionSection.vue';
import { 
    LineInput, 
    ChooseBrandInput as ChooseBrand, 
    ChooseColorInput as ChooseColor,
    TextareaInput as TextareaWysiwyg,
    StateSelectbox,
    EngineSelectbox,
    TransmissionSelectbox,
    ImageInput,
    AdditionalFieldsInput,
} from '@/Modules/Inputs';
import { Map, MapCitySearch } from '@/Modules/Map';
import { useCarForm } from './useCarForm';

const props = defineProps<{
    title: string,
    form: CarForm,
    url: string
    options?: Record<string, any>,
}>();

const emit = defineEmits<{
    (e: 'success', page: Page<PageProps>): void
}>();

defineExpose({
    form: props.form
});

const { form, error, processing, removeFile, submit } = useCarForm(props, emit);
</script>

<template>
    <ActionSection>
        <template #title>
            Add car basic information
        </template>

        <template #description>
            Fill the basic information about your car and your location to get started.
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="brand" value="Brand" />
                <ChooseBrand v-model.number="form.brand_id" name="brand" />
            </div>

            <div class="mb-2">
                <InputLabel for="model" value="Model" />
                <LineInput
                    id="model"
                    v-model="form.model"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="model"
                    />
            </div>

            <div class="mb-2">
                <InputLabel for="city" value="City" />
                <MapCitySearch
                    v-model:lat="form.location.lat"
                    v-model:lng="form.location.lng"
                    v-model:city="form.location.city"
                />

                <Map
                    v-model:radius.number="form.radius"
                    v-model:lat="form.location.lat"
                    v-model:lng="form.location.lng"
                    v-model:city="form.location.city"
                />
            </div>

            <div class="mb-2">
                <InputLabel for="price" value="Price" />
                <LineInput type="number" prefix="Kč" id="price" min="0" v-model="form.price" class="my-2 block w-full" required autofocus autocomplete="price" />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Car details
        </template>

        <template #description>
            Describe your car a bit more.
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="color" value="Car paint color" />
                <ChooseColor v-model="form.color" name="color" />
            </div>

            <div class="mb-2">
                <InputLabel for="kilometers" value="Kilometers" />
                <LineInput type="number" prefix="km" id="kilometers" min="0" v-model="form.kilometers" class="my-2 block w-full" required autofocus autocomplete="kilometers" />
            </div>

            <div class="flex gap-2 align-center mb-2">
                <div class="flex-1">
                    <InputLabel for="state" value="State" />
                    <StateSelectbox v-model="form.state" id="state" />
                </div>

                <div class="flex-1">
                    <InputLabel for="year" value="Year" />
                    <LineInput type="number" id="year" min="1900" v-model="form.year" class="w-full" required autofocus autocomplete="year" />
                </div>

            </div>

            <div class="flex gap-2 align-center mb-2">
                <div class="flex-1">
                    <InputLabel for="transmission" value="Transmission" />
                    <TransmissionSelectbox v-model="form.transmission" id="transmission" />
                </div>

                <div class="flex-1">
                    <InputLabel for="engine" value="Engine" />
                    <EngineSelectbox v-model="form.engine" id="engine" />
                </div>
            </div>

            <div class="mb-2">
                <InputLabel for="fual_transmission" value="Fuel transmission" />
                <LineInput type="number" prefix="l/100km" id="fual_transmission" min="0" v-model="form.fuel_consumption" class="my-2 block w-full" required autofocus autocomplete="off" />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Additional features
        </template>

        <template #description>
            Would you like to add some other information that is not included in the basic information?
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="additional_fields" value="Additional fields" />
                <AdditionalFieldsInput v-model="form.other_features" />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Images
        </template>

        <template #description>
            Add some images of your car and higher your chance to sell the car faster.
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="images" value="Images" />
                <ImageInput 
                    v-model="form.images_to_upload" 
                    :already-uploaded="form.images" 
                    :max-images="6"
                    @remove-existing-image="removeFile"
                />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Description
        </template>

        <template #description>
            Including all the information and describe your car in detail can help the buyer to make a decision.
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="description" value="Description" />
                <TextareaWysiwyg v-model="form.description" />
            </div>
        </template>
    </ActionSection>

    <Error :message="error" />

    <div class="flex items-center justify-end my-4">
        <PrimaryButton :class="{ 'opacity-25': processing }" :disabled="processing" @click="submit">
                Save
        </PrimaryButton>
    </div>
</template>