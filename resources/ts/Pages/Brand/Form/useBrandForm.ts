import { Page, PageProps } from "@inertiajs/core";
import { useForm } from "@inertiajs/vue3";
import { useProcessForm } from "@/Shared/Composables";
import { BrandForm } from "../types";

export function useBrandForm(
  props: { form: BrandForm; url: string; options?: Record<string, any> },
  emit: (e: 'success', page: Page<PageProps>) => void
) {
    const onSuccess = (page: Page<PageProps>) => {
        emit('success', page);
    };

    const form = useForm<BrandForm>(props.form);
    const { process, error, processing } = useProcessForm<BrandForm>(form, props.url, props.options, onSuccess);
        
    const submit = () => { 
        if (Array.isArray(form.logo) && form.logo.length > 0) {
            form.logo = form.logo[0];
        }

        process(); 
    };

    return { form, error, processing, submit };
}