import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { CarQuery, CarSearchForm } from './types';


export function useCarSearch(initialFilters: Partial<CarSearchForm>) {
    const form = reactive<CarSearchForm>({
        brand: initialFilters.brand ?? null,
        engine: initialFilters.engine,
        transmission: initialFilters.transmission,
        state: initialFilters.state,
        price: initialFilters.price ?? {min: undefined, max: undefined},
        color: initialFilters.color ?? "",
        km: initialFilters.km ?? {min: undefined, max: undefined},
        year: initialFilters.year ?? {min: undefined, max: undefined},
        fuel: initialFilters.fuel,
        wholeRepublic: initialFilters.wholeRepublic,
        location: {
            lat: initialFilters.location?.lat ?? 50.0158,
            lng: initialFilters.location?.lng ?? 15.7402,
            radius: initialFilters.location?.radius ?? 10,
            city: initialFilters.location?.city ?? ''
        }
    });

    const formatRange = (range: { min?: number, max?: number }) => {
        if (range.min === undefined && range.max === undefined) return undefined;
  
        const min = range.min ?? 0;
        const max = range.max ?? ''; 
        return `${min},${max}`;
    };

    const mapToQuery = () => {
        const query: CarQuery = {
            b: form.brand ?? undefined,
            e: form.engine,
            t: form.transmission,
            s: form.state,
            c: form.color || undefined,
            f: form.fuel,
            p: formatRange(form.price),
            km: formatRange(form.km),
            y: formatRange(form.year),
        };

        if (!form.wholeRepublic) {
            query.lat = Number(form.location.lat.toFixed(3));
            query.lng = Number(form.location.lng.toFixed(3));
            query.r = form.location.radius;
            query.w = false;
        } else {
            query.w = true;
        }

        return query;
    };

    const executeSearch = () => {
        const query = mapToQuery();

        router.visit(route('app_car_get', { ...query }));
    };

    return {
        form,
        executeSearch,
        mapToQuery
    };
}