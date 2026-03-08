<script setup lang="ts" generic="T extends number">
import { computed } from 'vue';
import { type Brand } from '@/Modules/Brand';
import { useFetch } from '@/Shared/Composables';
import { asset } from '@/Shared/Utils';
import ChooseInput from '../ChooseInput.vue';

const { data: brands, error, loading } = useFetch<Brand[]>(`/api/brands?page=1&limit=30`, { method: 'GET' });

const selectedBrand = defineModel<number | null>('selectedBrand', { default: null });
const initialBrandIndex = computed(() => selectedBrand.value 
    ? brands.value?.data?.findIndex(b => b.id === selectedBrand.value) 
    : undefined
);
</script>

<template>
    <ChooseInput
        v-if="!loading"
        :items="brands?.data || []"
        :initial-index="initialBrandIndex"
        @selected="(item: Brand) => selectedBrand = item?.id"
    >
        <template #errors>
            <span v-if="loading">Loading...</span>

            <span 
                v-if="error" 
                class="text-red-500"
            >
                Error loading brands ({{ error }})
            </span>
        </template>

        <template #option="{ item }: { item: Brand | null }">
            <div 
                v-if="!loading && item !== null" 
                class="flex gap-1"
            >
                <img 
                    v-if="item?.logo !== null" 
                    class="mx-1 size-7 rounded-full object-cover" 
                    :src="asset(item?.logo)" :alt="item?.name">
                {{ item?.name }}
            </div>
        </template>
    </ChooseInput>
</template>