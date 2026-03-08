<script setup lang="ts">
import { CarTransmissionType } from '@/Modules/Car';
import { capitalize } from '@/Shared/Utils';
import Selectbox from '../Selectbox.vue';

const model = defineModel<CarTransmissionType>({ default: CarTransmissionType.AUTOMATIC });
</script>

<template>
    <Selectbox v-model="model" id="transmission" class="w-full">
        <template #options>
            <option v-for="transmission in Object.values(CarTransmissionType)" :key="transmission" :value="transmission">
                {{ capitalize(transmission) }}
            </option>
        </template>
    </Selectbox>
</template>