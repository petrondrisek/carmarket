import { ref, onUnmounted } from 'vue';

interface LocalFile {
    url: string;
    file: File;
}

export function useImageUpload(maxImages: number = 5) {
    const localFiles = ref<LocalFile[]>([]);
    const isDragging = ref(false);

    const addFiles = (files: FileList | null) => {
        if (!files) return;

        const incoming = Array.from(files);
        const validImages = incoming.filter(f => f.type.startsWith('image/'));

        if (totalCount(validImages.length) > maxImages) {
            alert(`Maximální limit je ${maxImages} obrázků.`);
            return;
        }

        validImages.forEach(file => {
            localFiles.value.push({
                url: URL.createObjectURL(file),
                file: file
            });
        });
    };

    const removeFile = (index: number) => {
        const file = localFiles.value[index];
        if (file) {
            URL.revokeObjectURL(file.url);
            localFiles.value.splice(index, 1);
        }
    };

    const totalCount = (incomingCount: number = 0) => {
        return localFiles.value.length + incomingCount;
    };

    onUnmounted(() => {
        localFiles.value.forEach(f => URL.revokeObjectURL(f.url));
    });

    return {
        localFiles,
        isDragging,
        addFiles,
        removeFile
    };
}