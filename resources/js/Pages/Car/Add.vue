<script setup>
import Layout from '@/Layouts/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/JetStream/ActionSection.vue';
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import ChooseBrand from '@/Components/Inputs/ChooseBrand.vue';
import ChooseColor from '@/Components/Inputs/ChooseColor.vue';
import SearchCity from '@/Components/Map/SearchCity.vue';
import NumberInput from '@/Components/Inputs/NumberInput.vue';
import ImagesInput from '@/Components/Inputs/ImagesInput.vue';
import AdditionalFieldsInput from '@/Components/Inputs/AdditionalFieldsInput.vue';
import TextareaWysiwyg from '@/Components/Inputs/TextareaWysiwyg.vue';
import EngineSelectbox from '@/Components/Inputs/EngineSelectbox.vue';
import TransmissionSelectbox from '@/Components/Inputs/TransmissionSelectbox.vue';
import StateSelectbox from '@/Components/Inputs/StateSelectbox.vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';

const form = useForm({
    _method: 'POST',
    brand_id: null,
    model: '',
    color: null,
    kilometers: '0',
    location: {name: 'Pardubice', lat: 50.0158, lng: 15.7402},
    price: '0',
    engine: 'diesel',
    state: 'new',
    transmission: 'manual',
    year: new Date().getFullYear().toString(),
    images: [],
    other_features: {},
    description: 'Bez popisu',
    fuel_consumption: '5.0'
})

const { Success } = useFlashMessages( form );

const addNewCar = (event) => {
    event.preventDefault();

    form.post(route('app_car_store'), {
        onSuccess: () => {
            form.reset();
            Success('Car added successfully');
        }
    });
}
</script>

<template>
    <Head title="Add car"></Head>

    <action-section>
        <template #title>
            Add car basic information
        </template>

        <template #description>
            Fill the basic information about your car and your location to get started.
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="brand" value="Brand" />
                <choose-brand v-model="form.brand_id" name="brand" />
            </div>

            <div class="mb-2">
                <input-label for="model" value="Model" />
                <text-input
                    id="model"
                    v-model="form.model"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="model"
                    />
            </div>

            <div class="mb-2">
                <input-label for="city" value="City" />
                <search-city v-model="form.location" />
            </div>

            <div class="mb-2">
                <input-label for="price" value="Price" />
                <number-input prefix="Kč" id="price" min="0" v-model="form.price" class="my-2 block w-full" required autofocus autocomplete="price" />
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Car details
        </template>

        <template #description>
            Describe your car a bit more.
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="color" value="Car paint color" />
                <choose-color v-model="form.color" name="color" />
            </div>

            <div class="mb-2">
                <input-label for="kilometers" value="Kilometers" />
                <number-input prefix="km" id="kilometers" min="0" v-model="form.kilometers" class="my-2 block w-full" required autofocus autocomplete="kilometers" />
            </div>

            <div class="flex gap-2 align-center mb-2">
                <div class="flex-1">
                    <input-label for="state" value="State" />
                    <state-selectbox v-model="form.state" id="state" />
                </div>

                <div class="flex-1">
                    <input-label for="year" value="Year" />
                    <number-input id="year" min="1900" v-model="form.year" class="w-full" required autofocus autocomplete="year" />
                </div>

            </div>

            <div class="flex gap-2 align-center mb-2">
                <div class="flex-1">
                    <input-label for="transmission" value="Transmission" />
                    <transmission-selectbox v-model="form.transmission" id="transmission" />
                </div>

                <div class="flex-1">
                    <input-label for="engine" value="Engine" />
                    <engine-selectbox v-model="form.engine" id="engine" />
                </div>
            </div>

            <div class="mb-2">
                <input-label for="fual_transmission" value="Fuel transmission" />
                <number-input prefix="l/100km" id="fual_transmission" min="0" v-model="form.fuel_consumption" class="my-2 block w-full" required autofocus autocomplete="off" />
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Additional features
        </template>

        <template #description>
            Would you like to add some other information that is not included in the basic information?
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="additional_fields" value="Additional fields" />
                <additional-fields-input v-model="form.other_features" />
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Images
        </template>

        <template #description>
            Add some images of your car and higher your chance to sell the car faster.
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="images" value="Images" />
                <images-input v-model="form.images" :images="6"/>
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Description
        </template>

        <template #description>
            Including all the information and describe your car in detail can help the buyer to make a decision.
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="description" value="Description" />
                <textarea-wysiwyg v-model="form.description" />
            </div>
        </template>
    </action-section>

    <div class="flex items-center justify-end my-4">
        <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="addNewCar">
                Save
        </primary-button>
    </div>
</template>

<script>
export default { 
    layout: Layout 
};
</script>