import { PageProps } from "@/Shared/Types/PageProps";
import type { InertiaForm } from "@inertiajs/vue3";
import type { Page } from "@inertiajs/core";
import { route } from "ziggy-js";
import { ref, Ref, unref } from "vue";

export function useProcessForm<T extends Record<string, any>>(
    form: InertiaForm<T>, 
    url: string | Ref<string>,
    options: Record<string, any> | Ref<Record<string, any>> = {},
    onSuccessCallback?: (data: Page<PageProps>) => void,
    method: 'POST' | 'DELETE' = 'POST'
) {
    const processing = ref<boolean>(false);
    const progress = ref<number>(0);
    const error = ref<Record<string, any> | null>(null);

    let methodCallable = null;
    switch(method) {
        case 'POST': methodCallable = form.post.bind(form); break;
        case 'DELETE': methodCallable = form.delete.bind(form); break;
    }
    
    const process = () => {
        if (processing.value) return;
        processing.value = true;

        error.value = null;
        const targetUrl = route(unref(url), unref(options));

        methodCallable(targetUrl, {
            forceFormData: true,
            preserveScroll: true,
            onProgress: (event: any) => {
                if (event?.loaded && event?.total) {
                    progress.value = Math.round((event.loaded * 100) / event.total);
                }
            },

            onSuccess: (page: any) => {
                form.reset();
                progress.value = 0;

                processing.value = false;

                if (onSuccessCallback) {
                    onSuccessCallback(page);
                }
            },

            onError: (err: any) => {
                error.value = err;
                progress.value = 0;

                processing.value = false;
            }
        });
    }

    return {
        progress,
        process,
        error,
        processing
    }

}