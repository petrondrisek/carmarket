<script setup lang="ts">
import { Brand } from '@/Modules/Brand/brand.models';
import { SubTitle } from '@/Shared/Components';
import { asset } from '@/Shared/Utils';

const { brand } = defineProps<{
    brand: Brand
}>();
</script>

<template>
    <SubTitle class="detail-info-brand">About the brand {{ brand.name ?? 'Unknown brand' }}</SubTitle>
    
    <div class="grid grid-cols-4 gap-4">
        <img 
            v-if="brand.logo" 
            :src="asset(brand.logo)" 
            class="w-40 mx-auto col-span-4 md:col-span-1" 
            :alt="brand.name" 
        />
        
        <p 
            class="mt-2 col-span-4 md:col-span-3" 
            v-html="brand.description ?? 'No description'"
        ></p>
    </div>
</template>