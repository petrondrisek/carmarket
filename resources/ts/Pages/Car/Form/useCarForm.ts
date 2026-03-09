import { useForm } from "@inertiajs/vue3";
import { Page, PageProps } from "@inertiajs/core";
import { useProcessForm } from "@/Shared/Composables";
import { CarForm } from "../types";

export function useCarForm(
  props: { form: CarForm; url: string; options?: Record<string, any> },
  emit: (e: 'success', page: Page<PageProps>) => void
) {
    const onSuccess = (page: Page<PageProps>) => {
        emit('success', page);
    };

    const form = useForm<CarForm>(props.form);
    const { process, error, processing } = useProcessForm<CarForm>(form, props.url, props.options, onSuccess);

    const removeFile = (image: string) => {
        form.images = form.images.filter(i => !i.endsWith(image));
        form.images_to_delete.push(image);
    }

    const submit = () => {
        process();
    }

    return { form, error, processing, removeFile, submit};
}