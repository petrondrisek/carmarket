import { Brand } from "@/Modules/Brand/brand.models";
import { Car } from "@/Modules/Car/car.models";
import { User } from "@/Modules/JetStream/User";
import { Filters, FiltersExtended } from "@/Pages/Car/Search/types";

export interface Props<T> {
    data: T;
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    }
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth?: {
        user: User | null;
    };
    brands?: Props<Brand[]>;
    cars?: Props<Car[]>;
    queryParams?: FiltersExtended;
    flash?: {
        success?: string;
        error?: string;
    };
    [key: string]: any;
};