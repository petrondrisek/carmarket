<script setup lang="ts">
import { CarEngineType } from '@/Modules/Car';
import { capitalize } from '@/Shared/Utils';
import Selectbox from '../Selectbox.vue';

const model = defineModel<CarEngineType>({ default: CarEngineType.DIESEL });
</script>

<template>
    <Selectbox v-model="model" class="w-full" id="engine">
        <template #options>
            <option v-for="engine in Object.values(CarEngineType)" :key="engine" :value="engine">
                {{ capitalize(engine) }}
            </option>
        </template>
    </Selectbox>
</template>