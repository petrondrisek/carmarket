import { ref } from 'vue';

export function useChoose<T>(
    items: T[], 
    initialIndex = 0, 
    onSelected: (item: T) => void
) {
    const visible = ref<boolean>(false);
    const setVisible = (on: boolean) => visible.value = on;

    const selectedIndex = ref<number>(initialIndex);
    const setSelectedIndex = (index: number) => {
        selectedIndex.value = index;
        setVisible(false);

        onSelected(items[index]);
    }

    const onKeyDown = (event: KeyboardEvent) => {
        switch (event.key) {
            case 'Escape':
                setVisible(false);
                break;
        }
    }

    return { visible, setVisible, selectedIndex, setSelectedIndex, onKeyDown };
}