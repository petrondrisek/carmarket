import { Theme } from "@/Modules/Theme/theme.models";
import { useLocalStorage } from "@/Shared/Composables/useLocalStorage";
import { watch } from "vue";

export function useTheme() {
    const theme = useLocalStorage<Theme>('theme', Theme.Light);
    
    const changeTheme = (newTheme: Theme) => {
        if(!newTheme) return;

        theme.value = newTheme;
    }

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

    return { theme, changeTheme };
}