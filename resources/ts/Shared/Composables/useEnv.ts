export function useEnv() {
    const VITE_GOOGLE_MAPS_MAP_ID = import.meta.env.VITE_GOOGLE_MAP_ID ?? '';
    const VITE_GOOGLE_MAPS_API_KEY = import.meta.env.VITE_GOOGLE_MAP_API ?? '';

    return {
        VITE_GOOGLE_MAPS_MAP_ID,
        VITE_GOOGLE_MAPS_API_KEY
    }
}