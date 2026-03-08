<script setup lang="ts">
import { Table, SubTitle, Link } from '@/Shared/Components';
import { capitalize } from '@/Shared/Utils';
import { useSafeHtml } from '@/Shared/Composables';
import type { Car } from './car.models';
import { CarDetailTableRow } from './Components'

const { car } = defineProps<{
    car: Car
}>();

const description = useSafeHtml(car.description);
</script>

<template>
    <SubTitle>Detail info</SubTitle>
    
    <Table :headers="[]">
        <CarDetailTableRow header="Location">
            {{ car.location.city }} (Lat: {{ car.location.lat }}, Long: {{ car.location.lng }})
        </CarDetailTableRow>

        <CarDetailTableRow header="Color">
            <div 
                class="w-6 h-6 rounded-full border-2 border-gray-200 dark:border-gray-700" 
                :style="{ 'background-color': car.color }">
            </div>
        </CarDetailTableRow>
        
        <CarDetailTableRow header="Brand">
            {{ car.brand.name ?? 'Unknown brand' }}
            <slot name="brand-actions"></slot>
        </CarDetailTableRow>

        <CarDetailTableRow header="Year">
            {{ car.year }}
        </CarDetailTableRow>
            
        <CarDetailTableRow header="State">
            {{ capitalize(car.state) }}
        </CarDetailTableRow>
        
        <CarDetailTableRow header="Kilometers">
            {{ car.kilometers }} km
        </CarDetailTableRow>

        <CarDetailTableRow header="Engine">
            {{ capitalize(car.engine) }}
        </CarDetailTableRow>
        
        <CarDetailTableRow header="Transmission">
            {{ capitalize(car.transmission) }}
        </CarDetailTableRow>
        
        <CarDetailTableRow header="Fuel consumption">
            {{ car.fuel_consumption }} l/100km
        </CarDetailTableRow>

        <CarDetailTableRow 
            v-for="(field, key) in car.other_features" 
            :key="`other_feature_${key}`"
            :header="capitalize(key)"
        >
            {{ capitalize(field) }}
        </CarDetailTableRow>

        <CarDetailTableRow header="Seller">
            <p v-if="car.user.last_name">
                {{ car.user.name }} - {{ car.user.first_name ?? '' }} {{ car.user.last_name ?? '' }}
            </p>
            <p v-else>{{ car.user.name }}</p>
            
            <p>
                <strong>Phone</strong>: 
                <Link v-if="car.user.phone" :href="'tel:' + car.user.phone">{{ car.user.phone }}</Link>
                <span v-else>-</span>
            </p>
            <p>
                <strong>Email</strong>: 
                <Link :href="'mailto:' + car.user.email">{{ car.user.email }}</Link>
            </p>
        </CarDetailTableRow>
    </Table>


    <SubTitle>Description</SubTitle>
    <p  
        class="mt-2" 
        v-html="description"
    ></p>

</template>