<script setup>
import PrimaryButton from '../Forms/PrimaryButton.vue';
import SecondaryButton from '../Forms/SecondaryButton.vue';
import { router } from '@inertiajs/vue3';
import { ref, toRef } from 'vue';
import buildUrl from '../../Services/buildUrl';

const context = defineProps({
    store: Array,
    modelName: String,
    filters: Object,
    getRoute: String,
    startingPage: Number,
    lastPage: Number,
    base64: {
        type: Boolean,
        default: false
    }
});

const store = toRef(context, 'store');
const filters = toRef(context, 'filters');
const base64 = toRef(context, 'base64');
const nextPage = ref(context.startingPage + 1 <= context.lastPage ? context.startingPage + 1 : -1);

const loadMore = () => {
    if (nextPage.value == -1) return;

    router.get(route(context.getRoute), buildUrl(base64.value, filters.value, nextPage.value), {
        preserveScroll: true,
        preserveState: true,
        replace: false,
        onSuccess: (data) => {
            if(!data.props[context.modelName])
                throw new Error(`InfiniteLoading: Model '${context.modelName}' not found in GET result props.`);

            store.value.push(...data.props[context.modelName].data);
            
            nextPage.value = nextPage.value + 1 <= context.lastPage ? nextPage.value + 1 : -1;
        },
        
        onError: (err) => {
            console.log("InfiniteLoading error:", err);
        }
    });
}
</script>

<template>
    <div class="flex items-center gap-2 justify-center py-5">
        <SecondaryButton 
            v-if="nextPage !== 2" 
            @click="() => router.visit(route(context.getRoute, buildUrl(base64, filters, 1)))"
        >
        Start over
        </SecondaryButton>
        
        <PrimaryButton v-if="nextPage !== -1" @click="loadMore">Load More</PrimaryButton>
    </div>
</template>