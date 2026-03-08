export type Brand = {
    id: number;
    name: string;
    description: string;
    logo: string;
    stats: {
        total_cars: number;
    }
    created_at: string;
    is_active: boolean;
}