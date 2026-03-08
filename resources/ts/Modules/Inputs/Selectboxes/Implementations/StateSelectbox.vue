<script setup lang="ts">
import { CarStateType } from '@/Modules/Car';
import { capitalize } from '@/Shared/Utils';
import Selectbox from '../Selectbox.vue';

const model = defineModel<CarStateType>({ default: CarStateType.NEW});
</script>

<template>
    <Selectbox v-model="model" class="w-full" id="state">
        <template #options>
            <option v-for="state in Object.values(CarStateType)" :key="state" :value="state">
                {{ capitalize(state) }}
            </option>
        </template>
    </Selectbox>
</template>