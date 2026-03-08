import { Brand } from "../Brand/brand.models";
import { User } from "../JetStream/User";

export enum CarStateType { 
    NEW = 'new',
    USED = 'used',
    REFURBISHED = 'refurbished'
}

export enum CarEngineType {
    PETROL = 'petrol',
    DIESEL = 'diesel',
    ELECTRIC = 'electric',
    HYBRID = 'hybrid'
}

export enum CarTransmissionType {
    MANUAL = 'manual',
    AUTOMATIC = 'automatic'
}

export type Location = {
    city: string,
    lat: number,
    lng: number
}

export type Car = {
    id: number,
    brand: Brand,
    user: User,
    model: string,
    description: string,
    color: string,
    transmission: string,
    engine: CarEngineType,
    state: CarStateType,
    fuel_consumption: string,
    other_features: Record<string, string>,
    year: number,
    price: number,
    kilometers: number,
    images: string[],
    location: Location,
    is_new: boolean,
    is_sold?: boolean
}