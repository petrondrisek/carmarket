import { ref, watch } from 'vue';

export function useLocalStorage<T>(key: string, defaultValue: T){
    const isServer = typeof window === 'undefined';

    const getInitialValue = (): T => {
        if (isServer) return defaultValue;

        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (error) {
            console.error(`Error reading localStorage key "${key}":`, error);
            return defaultValue;
        }
    };

    const storedValue = ref<T>(getInitialValue());

    watch(storedValue, (newValue) => {
        if (isServer) return;

        try {
            window.localStorage.setItem(key, JSON.stringify(newValue));
        } catch (error) {
            console.error(`Error writing localStorage key "${key}":`, error);
        }
    }, { deep: true });

    return storedValue;
}