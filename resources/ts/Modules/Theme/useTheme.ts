import { readonly, watch } from "vue";
import { useLocalStorage } from "@/Shared/Composables";
import { Theme } from "./theme.models";

// Singleton
const theme = useLocalStorage<Theme>('theme', Theme.Light);

/**
 * Adds the current theme as a class
 */
watch(theme, (newVal, oldVal) => {
    document.documentElement.setAttribute('data-theme', newVal);

    if (oldVal) {
        document.documentElement.classList.remove(oldVal.toLowerCase());
    }
    document.documentElement.classList.add(newVal.toLowerCase());
    
    // For Tailwind's dark mode
    document.documentElement.classList.toggle('dark', newVal === Theme.Dark);
}, { immediate: true });

export function useTheme() {
    const changeTheme = (newTheme: Theme) => {
        if(!newTheme) return;
        theme.value = newTheme;
    }

    return { 
        theme: readonly(theme),
        changeTheme 
    };
}