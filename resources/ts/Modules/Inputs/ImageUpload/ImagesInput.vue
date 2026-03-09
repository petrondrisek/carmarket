<script setup lang="ts">
import { useTemplateRef, watch } from 'vue';
import { useImageUpload } from './useImageUpload';
import { asset } from '@/Shared/Utils';
import { useDragAndDrop } from '@/Shared/Composables';

interface Props {
    maxImages?: number;
    alreadyUploaded?: string[];
}

const props = withDefaults(defineProps<Props>(), {
    maxImages: 5,
    alreadyUploaded: () => []
});

const model = defineModel<File[]>();
const { localFiles, addFiles, removeFile } = useImageUpload(props.maxImages);
const inputRef = useTemplateRef('inputRef');

const handleRemove = (e: Event, index: number) => {
    e.preventDefault();
    removeFile(index);
}

const onDropEvent = (e: DragEvent) => {
    if(!e.dataTransfer?.files) return;
    addFiles(e.dataTransfer?.files);
}

const { isDragging, onDragEnter, onDragLeave, onDrop } = useDragAndDrop(onDropEvent);

watch(() => localFiles, () => {
    model.value = localFiles.value.map(f => f.file);
}, { deep: true });

const emit = defineEmits(['remove-existing-image']);
</script>

<template>
    <div
        @dragover.prevent
        @dragenter.prevent="onDragEnter"
        @dragleave.prevent="onDragLeave"
        @drop.prevent="onDrop"
        @click.prevent="inputRef?.click()"
    >
        <label 
            v-on="$attrs" 
            ref="labelRef" 
            class="cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-700 rounded p-4 flex flex-col items-center justify-center" 
            for="images"
        >
            <slot 
                v-if="!isDragging"
                name="click" 
            >
                <svg xmlns="http://www.w3.org/2000/svg" height="72px" viewBox="0 0 24 24" width="72px" class="fill-gray-300 dark:fill-gray-700">
                    <path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 20H4V6h9V4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-9h-2v9zm-7.79-3.17l-1.96-2.36L5.5 18h11l-3.54-4.71zM20 4V1h-2v3h-3c.01.01 0 2 0 2h3v2.99c.01.01 2 0 2 0V6h3V4h-3z"/>
                </svg>

                <span class="text-gray-600 dark:text-gray-400">
                    Drag and drop or click to upload
                </span>
            </slot>

            <slot 
                v-else
                name="drag-and-drop"
            >
                <svg xmlns="http://www.w3.org/2000/svg" height="72px" width="72px" viewBox="0 0 1024 1024" class="fill-gray-300 dark:fill-gray-700" version="1.1">
                    <path d="M682.666667 554.666667l297.130666 173.312-126.848 36.266666 90.666667 157.056-73.898667 42.666667-90.666666-157.013333-94.848 91.733333L682.666667 554.666667z m-85.333334-298.666667h85.333334v85.333333h213.333333a42.666667 42.666667 0 0 1 42.666667 42.666667v170.666667h-85.333334v-128H426.666667v426.666666h170.666666v85.333334H384a42.666667 42.666667 0 0 1-42.666667-42.666667v-213.333333H256v-85.333334h85.333333V384a42.666667 42.666667 0 0 1 42.666667-42.666667h213.333333V256zM170.666667 597.333333v85.333334H85.333333v-85.333334h85.333334z m0-170.666666v85.333333H85.333333v-85.333333h85.333334z m0-170.666667v85.333333H85.333333V256h85.333334z m0-170.666667v85.333334H85.333333V85.333333h85.333334z m170.666666 0v85.333334H256V85.333333h85.333333z m170.666667 0v85.333334h-85.333333V85.333333h85.333333z m170.666667 0v85.333334h-85.333334V85.333333h85.333334z"/>
                </svg>
                
                <span class="text-gray-600 dark:text-gray-400">
                    Drop to upload
                </span>
            </slot>
        </label>

        <ul class="flex overflow-x-auto gap-4 py-4 mt-4" ref="imagesRef">
            <li 
                v-for="(image, i) in alreadyUploaded" 
                :key="`selected-${i}`"
                class="min-w-[150px] w-[150px] border-2 border-gray-300 dark:border-gray-700 rounded p-2 relative flex flex-col justify-between" 
            >
                <img 
                    :src="asset(image)" 
                    :alt="image" 
                    class="image" 
                    width="100%" 
                />
                
                <p class="break-all text-sm text-gray-600">{{image}}</p>
                
                <button 
                    class="absolute top-[-12px] right-[-12px] bg-danger-500 hover:bg-danger-600 transition duration-150 ease-in-out cursor-pointer rounded-full text-white px-3 py-1" 
                    @click.stop="emit('remove-existing-image', image)"
                >
                    X
                </button>
            </li>
            <li 
                class="min-w-[150px] w-[150px] border-2 border-gray-300 dark:border-gray-700 rounded p-2 relative flex flex-col justify-between" 
                v-for="(image, i) in localFiles" 
                :key="image.url"
            >
                <img :src="image.url" width="100%" :alt="image.file.name" />
                
                <p class="break-all text-sm text-gray-600">{{image.file.name}}</p>
                
                <button 
                    class="absolute top-[-12px] right-[-12px] bg-danger-500 hover:bg-danger-600 transition duration-150 ease-in-out cursor-pointer rounded-full text-white px-3 py-1" 
                    @click.stop="handleRemove($event, i)"
                >
                    X
                </button>
            </li>
        </ul>
    </div>

    <input 
        ref="inputRef" 
        type="file" 
        multiple 
        accept="image/*" 
        class="hidden" 
        @change="(e: Event) => addFiles((e.target as HTMLInputElement).files)" 
    />
</template>

<script lang="ts">
export default { 
    inheritAttrs: false 
};
</script>