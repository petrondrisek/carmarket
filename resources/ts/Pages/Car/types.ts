import { CarEngineType, CarStateType, CarTransmissionType, Location } from "@/Modules/Car/car.models";

export interface CarForm {
    _method: 'GET' | 'POST' | 'PUT' | 'DELETE',
    brand_id: number|null,
    model: string,
    color: string,
    kilometers: number,
    location: Location,
    price: number,
    engine: CarEngineType,
    state: CarStateType,
    transmission: CarTransmissionType,
    year: string,
    images: string[],
    images_to_upload: File[],
    images_to_delete: string[],
    other_features: Record<string, string>,
    description: string,
    fuel_consumption: number,
    [key: string]: any
}