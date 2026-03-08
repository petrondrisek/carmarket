import { useForm } from "@inertiajs/vue3";
import { Page, PageProps } from "@inertiajs/core";
import { Ref } from "vue";
import { Map } from '@/Modules/Map';
import { useProcessForm } from "@/Shared/Composables";
import { CarForm } from "../types";

type MapInstance = InstanceType<typeof Map>;

export function useCarForm(
  props: { form: CarForm; url: string; options?: Record<string, any> },
  mapRef: Ref<MapInstance | null, any>,
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
        // location
        form.location = {
            city: mapRef.value?.city ?? '',
            lat: mapRef.value?.lat ?? 0,
            lng: mapRef.value?.lng ?? 0,
        }

        process();
    }

    return { form, error, processing, removeFile, submit};
}