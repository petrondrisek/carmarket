import { onMounted, onUnmounted, type Ref } from 'vue';

export function useClickOutside(
    elements: (Ref<HTMLElement | null>)[], 
    callback: () => void
) {
    const listener = (e: MouseEvent) => {
        const isInside = elements.some(el => el.value?.contains(e.target as Node));
        if (!isInside) callback();
    };

    onMounted(() => document.addEventListener('click', listener));
    onUnmounted(() => document.removeEventListener('click', listener));
}