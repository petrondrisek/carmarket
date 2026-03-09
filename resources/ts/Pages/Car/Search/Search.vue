<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue';
import { Map, MapCitySearch } from '@/Modules/Map';
import {
    RangeInput,
    ChooseBrandInput as ChooseBrand,
    ChooseColorInput as ChooseColor,
    LineInput,
    EngineSelectbox,
    TransmissionSelectbox,
    StateSelectbox,
    Checkbox
} from '@/Modules/Inputs'
import ActionSection from '@/Modules/JetStream/ActionSection.vue';
import InputLabel from '@/Modules/JetStream/Forms/InputLabel.vue';
import { PrimaryButton } from '@/Shared/Components';
import { PageProps } from '@/Shared/Types';
import { useCarSearch } from './useCarSearch';

const props = usePage<PageProps>().props;
const { form, executeSearch } = useCarSearch(props.queryParams ?? {});
</script>

<template>
    <Head title="Search"></Head>

    <ActionSection>
        <template #title>
            Basic information
        </template>
        <template #description>
            Lorem ipsum
        </template>
        <template #content>
            <div class="mb-2">
                <InputLabel for="brand" value="Brand" />
                <ChooseBrand v-model.number="form.brand" id="brand"/>
            </div>

            <div class="mb-2">
                <InputLabel for="engine" value="Engine" />
                <EngineSelectbox v-model="form.engine" id="engine" />
            </div>

            <div class="mb-2">
                <InputLabel for="transmission" value="Transmission" />
                <TransmissionSelectbox v-model="form.transmission" id="transmission" />
            </div>

            <div class="mb-2">
                <InputLabel for="state" value="State" />
                <StateSelectbox v-model="form.state" id="state" />
            </div>

            <div class="mb-2 flex gap-2">
                <div class="flex-1 w-full">
                    <InputLabel for="minPrice" value="Min price" />
                    <LineInput type="number" id="minPrice" min="0" v-model="form.price.min" class="my-2 block w-full" required autofocus autocomplete="minPrice" />
                </div>

                <div class="flex-1 w-full">
                    <InputLabel for="maxPrice" value="Max price" />
                    <LineInput type="number" id="maxPrice" min="0" v-model="form.price.max" class="my-2 block w-full" required autofocus autocomplete="maxPrice" />
                </div>
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Car details
        </template>

        <template #description>
            Lorem ipsum
        </template>

        <template #content>
            <div class="mb-2">
                <InputLabel for="color" value="Color" />
                <ChooseColor v-model="form.color" name="color" />
            </div>

            <div class="mb-2 flex gap-2">
                <div class="flex-1 w-full">
                    <InputLabel for="minKilometers" value="Min kilometers" />
                    <LineInput type="number" id="minKilometers" min="0" v-model="form.km.min" class="my-2 block w-full" required autofocus autocomplete="minYear" />
                </div>

                <div class="flex-1 w-full">
                    <InputLabel for="maxKilometers" value="Max kilometers" />
                    <LineInput type="number" id="maxKilometers" min="0" v-model="form.km.max" class="my-2 block w-full" required autofocus autocomplete="maxYear" />
                </div>
            </div>

            <div class="mb-2 flex gap-2">
                <div class="flex-1 w-full">
                    <InputLabel for="minYear" value="Min year" />
                    <LineInput type="number" id="minYear" min="0" v-model="form.year.min" class="my-2 block w-full" required autofocus autocomplete="minYear" />
                </div>

                <div class="flex-1 w-full">
                    <InputLabel for="maxYear" value="Max year" />
                    <LineInput type="number" id="maxYear" min="0" v-model="form.year.max" class="my-2 block w-full" required autofocus autocomplete="maxYear" />
                </div>
            </div>

            <div class="mb-2">
                <InputLabel for="fuel_consumption" value="Fuel consumption" />
                <LineInput type="number" prefix="l/100km" id="fuel_consumption" min="0" v-model="form.fuel" class="my-2 block w-full" required autofocus autocomplete="off" />
            </div>
        </template>
    </ActionSection>

    <ActionSection>
        <template #title>
            Select city & radius around:
        </template>

        <template #description>
            Lorem ipsum
        </template>

        <template #content>
            <div class="mb-4 flex gap-1 flex-wrap">
                <Checkbox v-model:checked="form.wholeRepublic" id="wholeRepublic" class="mr-2 inline" />
                <InputLabel for="wholeRepublic" value="Search in whole republic" class="inline" />
            </div>

            <RangeInput 
                :min="5" 
                :max="100" 
                :step="5" 
                stateAlign="right" 
                v-model.number="form.location.radius" 
                unit="km" 
                :breakpoints="[25, 50, 75]"
            />

            <MapCitySearch
                v-model:lat="form.location.lat"
                v-model:lng="form.location.lng"
                v-model:city="form.location.city"
            />

            <Map
                v-model:radius.number="form.location.radius" 
                v-model:lat="form.location.lat" 
                v-model:lng="form.location.lng"
                v-model:city="form.location.city"
            />
        </template>
    </ActionSection>


    <div class="flex justify-end my-4">
        <PrimaryButton type="submit" @click="executeSearch">Search</PrimaryButton>
    </div>
</template>

<script lang="ts">
export default { layout: Layout };
</script>