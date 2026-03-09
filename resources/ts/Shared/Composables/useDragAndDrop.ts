import { ref } from "vue";

export function useDragAndDrop(
    onDropEvent: (e: DragEvent) => void,
) {
    let dragCounter = 0;
    const isDragging = ref(false);

    const onDragEnter = () => {
        dragCounter++;
        isDragging.value = true;
    };

    const onDragLeave = () => {
        dragCounter--;
        if (dragCounter === 0) {
            isDragging.value = false;
        }
    };

    const onDrop = (e: DragEvent) => {
        dragCounter = 0; // Reset
        isDragging.value = false;

        onDropEvent(e);
    }

    return { isDragging, onDragEnter, onDragLeave, onDrop };
}