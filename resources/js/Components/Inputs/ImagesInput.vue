<script setup>
import { useTemplateRef, computed, ref, onMounted, watch } from 'vue';

// Define
const props = defineProps({
    modelValue: {type: Array, default: []},
    images: {type: Number, default: 1},
    selected: {type: Array, default: []},
});

const emit = defineEmits([
    'update:modelValue'
]);

// Refs
const dragCounter = ref(0);
const dragEnter = ref(false);
const inputRef = useTemplateRef('inputRef');
const imagesRef = useTemplateRef('imagesRef');
const attachedImages = ref([]);
const selectedImages = ref(props.selected);

const value = computed({
    get: () => props.modelValue,
    set: (val) => {
        if (props.modelValue !== val) {
            emit('update:modelValue', val);
        }
    }
});

// Methods
const attachImage = (e) => {
    let files = e.target.files;
    addImage(files);
    inputRef.value.value = null;
}


const attachDropImage = (e) => {
    e.preventDefault();
    e.stopPropagation();

    let files = e.dataTransfer.files;
    addImage(files);   
    dragEnter.value = false;
}

const addImage = (files) => {
    // Check if image limit has been reached
    if(attachedImages.value.length + files.length + selectedImages.value.length > props.images) {
        alert('You can only upload ' + props.images + ' images at a time.');
        return;
    }

    else
    {
        for (let i = 0; i < files.length; i++) {
            // Check if file is an image
            if(files[i].type.split('/')[0] !== 'image') {
                alert(`File ${files[i].name} is not an image, this file was skipped.`);
                continue;
            }

            attachedImages.value.push({
                blob: URL.createObjectURL(files[i]),
                file: files[i]
            });
        }
    }
}

const removeImage = (e, index) => {
    URL.revokeObjectURL(attachedImages.value[index].blob);
    attachedImages.value.splice(index, 1);
    e.preventDefault();
}

const removeSelectedImage = (e, image) => {
    selectedImages.value.splice(selectedImages.value.indexOf(image), 1);
    e.preventDefault();
}

const onDragEnter = (e) => {
    dragCounter.value++;
    dragEnter.value = true;
}

const onDragLeave = (e) => {
  dragCounter.value--;
  if (dragCounter.value <= 0) {
    dragEnter.value = false;
    dragCounter.value = 0;
  }
}

const onDragEnd = (e) => {
  dragCounter.value = 0;
  dragEnter.value = false;
};

// Hooks
onMounted(() => {
    watch(
        attachedImages, 
        (newImages) => {
            value.value = newImages.map(img => img.file);
        }, 
        { 
            deep: true 
        }
    );
});

defineExpose({ selectedImages });
</script>

<template>
    <div
    @dragover.prevent
    @dragenter.prevent="onDragEnter"
    @dragleave.prevent="onDragLeave"
    @dragend.prevent="onDragEnd"
    @drop.prevent="attachDropImage"
    >
        <label 
        v-on="$attrs" 
        ref="labelRef" 
        class="cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-700 rounded p-4 flex flex-col items-center justify-center" 
        for="images"
        >
            <slot name="click" v-if="!dragEnter">
                <svg xmlns="http://www.w3.org/2000/svg" height="72px" viewBox="0 0 24 24" width="72px" class="fill-gray-300 dark:fill-gray-700">
                    <path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 20H4V6h9V4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-9h-2v9zm-7.79-3.17l-1.96-2.36L5.5 18h11l-3.54-4.71zM20 4V1h-2v3h-3c.01.01 0 2 0 2h3v2.99c.01.01 2 0 2 0V6h3V4h-3z"/>
                </svg>

                <span class="text-gray-600 dark:text-gray-400">
                    Drag and drop or click to upload
                </span>
            </slot>

            <slot name="drag-and-drop" v-else>
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
            class="min-w-[150px] w-[150px] border-2 border-gray-300 dark:border-gray-700 rounded p-2 relative flex flex-col justify-between" 
            v-for="(image, i) in selectedImages" 
            :key="`selected-${i}`"
            >
                <img :src="`/storage/${image}`" class="image" width="100%" :alt="image" />
                <p class="break-all text-sm text-gray-600">{{image}}</p>
                <button class="absolute top-[-12px] right-[-12px] bg-danger-500 hover:bg-danger-600 transition duration-150 ease-in-out cursor-pointer rounded-full text-white px-3 py-1" @click="(e) => removeSelectedImage(e, image)">X</button>
            </li>
            <li 
            class="min-w-[150px] w-[150px] border-2 border-gray-300 dark:border-gray-700 rounded p-2 relative flex flex-col justify-between" 
            v-for="(image, i) in attachedImages" 
            :key="image.file.id"
            >
                <img :src="image.blob" width="100%" :alt="image.file.name" />
                <p class="break-all text-sm text-gray-600">{{image.file.name}}</p>
                <button class="absolute top-[-12px] right-[-12px] bg-danger-500 hover:bg-danger-600 transition duration-150 ease-in-out cursor-pointer rounded-full text-white px-3 py-1" @click="(e) => removeImage(e, i)">X</button>
            </li>
        </ul>
    </div>

    <input 
    :multiple="images > 1"
    type="file" 
    accept="image/*"  
    id="images"
    ref="inputRef"
    @change="attachImage"
    class="hidden"
    >
</template>

<script>
export default { inheritAttrs: false };
</script>