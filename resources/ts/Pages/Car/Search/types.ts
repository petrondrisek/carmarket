import { CarEngineType, CarStateType, CarTransmissionType } from "@/Modules/Car";

export interface CarQuery {
    b?: number;  // brand
    c?: string;  // color
    t?: CarTransmissionType;
    e?: CarEngineType;
    s?: CarStateType;
    p?: string;  // "min,max"
    y?: string;  // "min,max"
    km?: string; // "min,max"
    f?: number;  // fuel
    w?: boolean; // ignore lat, lng, r and search in whole republic
    r?: number;  // radius
    lat?: number;
    lng?: number;
    page?: number;
}

type Location = {
    lat: number;
    lng: number;
    radius: number;
    city?: string;
}

export interface CarSearchForm {
    brand: number | null;
    engine?: CarEngineType;
    transmission?: CarTransmissionType;
    state?: CarStateType;
    color?: string;
    price: { min?: number; max?: number };
    km: { min?: number; max?: number };
    year: { min?: number; max?: number };
    fuel?: number;
    wholeRepublic?: boolean;
    location: Location;
}