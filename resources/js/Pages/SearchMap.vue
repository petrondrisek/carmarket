<script setup>
import Map from '@/Components/Map/Map.vue';
import RangeInput from '@/Components/Inputs/RangeInput.vue';
import ActionSection from '@/Components/JetStream/ActionSection.vue';
import Layout from '@/Layouts/Layout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { onMounted, ref, useTemplateRef, watch } from 'vue';
import SearchCity from '@/Components/Map/SearchCity.vue';
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import ChooseBrand from '@/Components/Inputs/ChooseBrand.vue';
import NumberInput from '@/Components/Inputs/NumberInput.vue';
import EngineSelectbox from '@/Components/Inputs/EngineSelectbox.vue';
import TransmissionSelectbox from '@/Components/Inputs/TransmissionSelectbox.vue';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import StateSelectbox from '@/Components/Inputs/StateSelectbox.vue';
import ChooseColor from '@/Components/Inputs/ChooseColor.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';

const props = usePage()?.props;
const activeFilters = props?.queryParams?.filters ?? {};

// Input
const brand = ref(activeFilters.brand_id ?? null);
const engine = ref(activeFilters.engine ?? null);
const transmission = ref(activeFilters.transmission ?? null);
const state = ref(activeFilters.state ?? null);
const minPrice = ref(activeFilters.min_price ?? '0');
const maxPrice = ref(activeFilters.max_price ?? '0');
const color = ref(activeFilters.color ?? null);
const kilometers = ref(activeFilters.kilometers ?? '0');
const minYear = ref(activeFilters.min_year ?? '0');
const maxYear = ref(activeFilters.max_year ?? '0');
const fuelConsumption = ref(activeFilters.fuel_consumption ?? '0');
const city = ref(activeFilters.lat ? {name: activeFilters.city, lat: activeFilters.lat, lng: activeFilters.lng} : { name: 'Pardubice', lat: 50.032, lng: 15.772 });
const radius = ref(activeFilters.radius ?? '5');
const wholeRepublic = ref(!activeFilters.lat);

// Refs
const searchCityRef = useTemplateRef('searchCityRef');
const mapRef = useTemplateRef('mapRef');

const changeMapLocation = (lat, lng, rad, cityName) => { 
    wholeRepublic.value = false;

    mapRef.value.changeMapLocation(Number(lat), Number(lng), Number(rad ?? radius.value), cityName); 
}

const startSearch = () => {
    const query = { 
        brand_id: brand.value,
        engine: engine.value,
        transmission: transmission.value,
        state: state.value,
        min_price: minPrice.value,
        max_price: maxPrice.value,
        fuel_consumption: fuelConsumption.value,
        color: color.value,
        kilometers: kilometers.value,
        min_year: minYear.value,
        max_year: maxYear.value,
        city: wholeRepublic.value ? null : city.value.name,
        lat: wholeRepublic.value ? null : mapRef.value.selectedLat, 
        lng: wholeRepublic.value ? null : mapRef.value.selectedLng, 
        radius: wholeRepublic.value ? null : radius.value,
        page: 1
    };

    const cleanQuery = Object.fromEntries(Object.entries(query).filter(([_, v]) => v !== null && v !== 0 && v !== '0'));
    const encoded = btoa(encodeURIComponent(JSON.stringify(cleanQuery)));

    router.visit(route('app_car_get', { q: encoded} ));
}

onMounted(() => {
    watch(() => mapRef.value.selectedCity, (value) => {
        city.value.name = searchCityRef.value.clearCityName(value); 
        searchCityRef.value.preventSearch();
    });
});
</script>

<template>
    <Head title="Search"></Head>

    <action-section>
        <template #title>
            Basic information
        </template>
        <template #description>
            Lorem ipsum
        </template>
        <template #content>
            <div class="mb-2">
                <input-label for="brand" value="Brand" />
                <choose-brand v-model="brand" id="brand" />
            </div>

            <div class="mb-2">
                <input-label for="engine" value="Engine" />
                <engine-selectbox v-model="engine" id="engine" />
            </div>

            <div class="mb-2">
                <input-label for="transmission" value="Transmission" />
                <transmission-selectbox v-model="transmission" id="transmission" />
            </div>

            <div class="mb-2">
                <input-label for="state" value="State" />
                <state-selectbox v-model="state" id="state" />
            </div>

            <div class="mb-2 flex gap-2">
                <div class="flex-1">
                    <input-label for="minPrice" value="Min price" />
                    <number-input id="minPrice" min="0" v-model="minPrice" class="my-2 block w-full" required autofocus autocomplete="minPrice" />
                </div>

                <div class="flex-1">
                    <input-label for="maxPrice" value="Max price" />
                    <number-input id="maxPrice" min="0" v-model="maxPrice" class="my-2 block" required autofocus autocomplete="maxPrice" />
                </div>
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Car details
        </template>

        <template #description>
            Lorem ipsum
        </template>

        <template #content>
            <div class="mb-2">
                <input-label for="color" value="Color" />
                <choose-color v-model="color" name="color" />
            </div>

            <div class="mb-2">
                <input-label for="kilometers" value="Kilometers" />
                <number-input prefix="km" id="kilometers" min="0" v-model="kilometers" class="my-2 block" required autofocus autocomplete="kilometers" />
            </div>

            <div class="mb-2 flex gap-2">
                <div class="flex-1">
                    <input-label for="minYear" value="Min year" />
                    <number-input id="minYear" min="0" v-model="minYear" class="my-2 block w-full" required autofocus autocomplete="minYear" />
                </div>

                <div class="flex-1">
                    <input-label for="maxYear" value="Max year" />
                    <number-input id="maxYear" min="0" v-model="maxYear" class="my-2 block" required autofocus autocomplete="maxYear" />
                </div>
            </div>

            <div class="mb-2">
                <input-label for="fuel_consumption" value="Fuel consumption" />
                <number-input prefix="l/100km" id="fuel_consumption" min="0" v-model="fuelConsumption" class="my-2 block w-full" required autofocus autocomplete="off" />
            </div>
        </template>
    </action-section>

    <action-section>
        <template #title>
            Select city & radius around:
        </template>

        <template #description>
            Lorem ipsum
        </template>

        <template #content>
            <div class="mb-4">
                <Checkbox v-model:checked="wholeRepublic" id="wholeRepublic" class="mr-2 inline" />
                <input-label for="wholeRepublic" value="Search in whole republic" class="inline" />
            </div>

            <search-city ref="searchCityRef" v-model="city" @changeMapLocation="changeMapLocation" />
            
            <range-input 
            @input="() => changeMapLocation(mapRef.selectedLat, mapRef.selectedLng, radius, mapRef.selectedCity)" 
            :min="5" 
            :max="100" 
            :step="5" 
            stateAlign="right" 
            v-model="radius" 
            unit="km" 
            :breakpoints="[25, 50, 75]"
            />
            
            <Map ref="mapRef" :city="city" :radius="Number(radius)"></Map>
        </template>
    </action-section>


    <div class="flex justify-end my-4">
        <primary-button type="submit" @click="startSearch">Search</primary-button>
    </div>
</template>

<script>
export default { layout: Layout };
</script>