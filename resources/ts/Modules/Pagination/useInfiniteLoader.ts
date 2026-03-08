import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { LoadMorePaginationConfig } from '@/Modules/Pagination/pagination.models';

export function useInfiniteLoader(config: LoadMorePaginationConfig) {
    const currentPage = ref(config.startingPage);
    const loading = ref(false);

    const hasNextPage = computed(() => currentPage.value < config.lastPage);

    const params = computed(() => {
        return {
            per_page: config.perPage ?? null,
            ...config.filters
        };
    });

    const loadMore = () => {
        if (loading.value || !hasNextPage.value) return;
        
        loading.value = true;
        const nextPage = currentPage.value + 1;

        router.get(route(config.getRoute), { ...params.value, page: nextPage }, {
            preserveScroll: true,
            preserveState: true,
            only: [config.modelName],
            onSuccess: (page) => {
                const result = page.props[config.modelName] as any;
                if (result?.data) {
                    config.onLoad?.(result.data);
                    currentPage.value = nextPage;
                }
            },
            onFinish: () => {
                loading.value = false;
            }
        });
    };

    const startOver = () => {
        router.visit(route(config.getRoute, { ...params.value, page: 1 }));
    };

    return {
        currentPage,
        loading,
        hasNextPage,
        loadMore,
        startOver
    };
}