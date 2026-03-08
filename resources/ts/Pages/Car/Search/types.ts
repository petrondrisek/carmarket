import { CarEngineType, CarStateType, CarTransmissionType } from "@/Modules/Car/car.models";

export interface Filters {
    b?: string; // brand ids (accepted: 1,2,3 or just 1)
    c?: string; // colors (accepted: red,blue,green or just red)
    t?: CarTransmissionType; // transmission
    p?: string // price range (accepted: min,max or just min)
    y?: string // year range (accepted: min,max or just min)
    km?: string // kilometers range (accepted: min,max or just min)
    e?: CarEngineType; // engine type
    s?: CarStateType; // state type
    r?: number; // radius
    f?: number; // fuel consumption 
    lat?: number; // latitude
    lng?: number; // longitude
    page?: number; // pagination
}

export interface FiltersExtended {
    brand?: number | null;
    engine?: CarEngineType;
    transmission?: CarTransmissionType;
    state?: CarStateType;
    price: { min?: number; max?: number };
    color?: string;
    km: { min?: number; max?: number };
    year: { min?: number; max?: number };
    fuel?: number;
    radius?: number;
    wholeRepublic?: boolean;
    lat?: number;
    lng?: number;
    page?: number;
}

export interface FiltersExtendedFree extends Omit<FiltersExtended, 'price' | 'km' | 'year'> {
    price?: { min?: number; max?: number };
    km?: { min?: number; max?: number };
    year?: { min?: number; max?: number };
}