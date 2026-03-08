import { Map } from '@/Modules/Map';
import { FiltersExtendedFree } from './types';
import { Ref, watch } from 'vue';

export function useMapSearchSync(
    form: FiltersExtendedFree,
    mapRef: Ref<InstanceType<typeof Map> | null>
) {
    const updateMap = () => {
        mapRef.value?.updateRadius(form.radius ?? 10);
        mapRef.value?.updatePosition(form.lat ?? 0, form.lng ?? 0);
    };

    watch(() => form.radius, () => updateMap());
    watch(
        () => [form.lat, form.lng],
        () => updateMap()
    );
}