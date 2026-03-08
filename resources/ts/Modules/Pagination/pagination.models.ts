export interface LoadMorePaginationConfig {
    modelName: string;
    getRoute: string;
    startingPage: number;
    lastPage: number;
    perPage?: number;
    filters?: Record<string, any>;
    onLoad?: (newItems: any[]) => void;
}

export type LinkType = {
    id: number;
    url?: string | null;
    label: string;
    active: boolean;
};