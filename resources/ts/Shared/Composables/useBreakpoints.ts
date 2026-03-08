import { ref, onMounted, onUnmounted } from 'vue';

export function useBreakpoints(width: number) {
    const isMobile = ref<boolean>(false);

    const update = (e: MediaQueryList | MediaQueryListEvent) => {
        isMobile.value = !e.matches;
    };

    onMounted(() => {
        const mediaQuery = window.matchMedia(`(min-width: ${width}px)`);
        isMobile.value = !mediaQuery.matches;
        mediaQuery.addEventListener('change', update);
    });

    onUnmounted(() => {
        const mediaQuery = window.matchMedia(`(min-width: ${width}px)`);
        mediaQuery.removeEventListener('change', update);
    });

    return { isMobile };
}