import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Filters, FiltersExtended, FiltersExtendedFree } from '@/Pages/Car/Search/types';


export function useCarSearch(initialFilters: FiltersExtendedFree) {
    const form = reactive<FiltersExtended>({
        brand: initialFilters.brand ?? null,
        engine: initialFilters.engine,
        transmission: initialFilters.transmission,
        state: initialFilters.state,
        price: initialFilters.price ?? {min: undefined, max: undefined},
        color: initialFilters.color ?? "",
        km: initialFilters.km ?? {min: undefined, max: undefined},
        year: initialFilters.year ?? {min: undefined, max: undefined},
        fuel: initialFilters.fuel,
        radius: Number(initialFilters.radius) || 10,
        wholeRepublic: !initialFilters.lat,
        lat: Number(initialFilters.lat) || 50.722,
        lng: Number(initialFilters.lng) || 15.056,
    });

    const formatRange = (range: { min?: number, max?: number }) : string => {
        const min = range.min ?? 0;
        const max = range.max;

        if (range.min === undefined && range.max === undefined) return "";
        return (!max || min > max) ? `${min}` : `${min},${max}`;
    };

    const mapToQuery = (input: FiltersExtended): Filters => {
        const q: Filters = {};
        
        const mapping: Record<string, keyof Filters> = {
            brand: 'b', engine: 'e', transmission: 't', 
            state: 's', fuel: 'f', color: 'c'
        };

        Object.entries(mapping).forEach(([formKey, queryKey]) => {
            const val = input[formKey as keyof FiltersExtended];
            if (val) (q as any)[queryKey] = val;
        });

        if (input.price?.min !== undefined || input.price?.max !== undefined) {
            q.p = formatRange(input.price);
        }

        if (!input.wholeRepublic && input.lat && input.lng && input.radius) {
            q.lat = input.lat;
            q.lng = input.lng;
            q.r = input.radius;
        }

        return q;
    };

    const executeSearch = () => {
        const query = mapToQuery(form);
        console.log(query);
        router.visit(route('app_car_get', { ...query }));
    };

    return {
        form,
        executeSearch,
        mapToQuery
    };
}