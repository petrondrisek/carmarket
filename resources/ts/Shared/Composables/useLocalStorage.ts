import { ref, watch, onMounted, Ref } from 'vue';

export function useLocalStorage<T>(key: string, defaultValue: T){
    const storedValue = ref<T>(defaultValue);

    const load = () => {
        try {
            const item = window.localStorage.getItem(key);
            if (item) {
                storedValue.value = JSON.parse(item);
            }
        } catch (error) {
            console.error(`Error reading localStorage key "${key}":`, error);
        }
    };

    watch(storedValue, (newValue) => {
        try {
            window.localStorage.setItem(key, JSON.stringify(newValue));
        } catch (error) {
            console.error(`Error writing localStorage key "${key}":`, error);
        }
    }, { deep: true });

    // prevent SSR running by using onMounted
    onMounted(load);

    return storedValue;
}