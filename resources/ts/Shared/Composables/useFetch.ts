import type { FetchComposable } from '@/Shared/Types/FetchComposable';
import { MaybeRef, Ref, ref, unref, watch } from 'vue';
import { Props } from '../Types/PageProps';

export function useFetch<T>(
    url: MaybeRef<string | null>, 
    options?: RequestInit
): FetchComposable<T> {
    let loading = ref<boolean>(false);
    let error = ref<string | null>(null);
    let data = ref<T | null>(null);

    let controller: AbortController | null = null;

    const fetchData = async (url: string) => {
        if (controller) controller.abort();
        controller = new AbortController();

        error.value = null;
        loading.value = true;

        try {
            const response = await fetch(
                url,
                { ...options, signal: controller.signal }
            );

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to fetch');
            }

            data.value = await response.json();
        } catch (e: any) {
            if(e.name === 'AbortError') return;

            console.error('Error fetching data:', e);
            error.value = (e as Error).message || 'An error occurred';
        } finally {
            if (!controller.signal.aborted) {
                loading.value = false;
            }
        }
    };

    watch(() => unref(url), (newUrl) => {
        if (newUrl) {
            fetchData(newUrl);
        } else {
            data.value = null;
            loading.value = false;
        }
    }, { immediate: true });

    return {
        data: data as Ref<Props<T>>,
        error: error as Ref<string | null>,
        loading: loading as Ref<boolean>
    };
}