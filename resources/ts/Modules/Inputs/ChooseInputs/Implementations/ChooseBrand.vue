<script setup lang="ts" generic="T extends number">
import { computed, ref, watch } from 'vue';
import { type Brand } from '@/Modules/Brand';
import { useFetch } from '@/Shared/Composables';
import { asset } from '@/Shared/Utils';
import ChooseInput from '../ChooseInput.vue';

const { data: brands, error, loading } = useFetch<Brand[]>(`/api/brands?page=1&limit=30`, { method: 'GET' });

const [model, modifiers] = defineModel<number | string | null>({
    set(value) {
        if (modifiers.number) {
            const num = Number(value);
            return isNaN(num) ? null : num;
        }
        return value;
    }
});

const initialBrandIndex = computed(() => {
    const list = brands.value?.data;
    if (!list || model.value === null) return 0;
    
    const index = list.findIndex(b => b.id === Number(model.value));
    return index !== -1 ? index : 0;
});
</script>

<template>
    <ChooseInput
        v-if="!loading && brands?.data?.length"
        :items="brands?.data || []"
        :initial-index="initialBrandIndex"
        @selected="(item: Brand) => model = item?.id"
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