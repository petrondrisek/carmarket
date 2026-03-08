<script setup lang="ts">
import { PrimaryButton, SecondaryButton } from '@/Shared/Components';
import { LoadMorePaginationConfig } from '../pagination.models';
import { useInfiniteLoader } from '../useInfiniteLoader';

const props = withDefaults(defineProps<LoadMorePaginationConfig>(), {
    filters: () => ({} as Record<string, any>),
});

const emit = defineEmits<{
    (e: 'loaded', items: any[]): void;
}>();

const { currentPage, loading, hasNextPage, loadMore, startOver } = useInfiniteLoader({
    ...props,
    onLoad: (items: any[]) => emit('loaded', items)
});
</script>

<template>
    <div class="flex flex-col items-center gap-3 py-6">
        <div class="flex items-center gap-2">
            <SecondaryButton v-if="currentPage > 1" @click="startOver">
                Start over
            </SecondaryButton>
            
            <PrimaryButton 
                v-if="hasNextPage" 
                :disabled="loading" 
                @click="loadMore"
            >
                <template v-if="loading">Loading...</template>
                <template v-else>Load More</template>
            </PrimaryButton>
        </div>
        
        <span class="text-[10px] uppercase tracking-widest text-gray-400">
            Strana {{ currentPage }} z {{ lastPage }}
        </span>
    </div>
</template>