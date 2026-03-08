<script setup lang="ts">
import { computed, watch, useTemplateRef, onUnmounted, nextTick, ref } from 'vue';
import { BreakpointKeys } from '@/Shared/Types/Breakpoints';

const props = defineProps<{
    maxWidth?: BreakpointKeys;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

// Tailwind safelist: sm:max-w-sm, sm:max-w-md, sm:max-w-lg, sm:max-w-xl, sm:max-w-2xl
const maxWidthClass = computed(() => `sm:max-w-${props.maxWidth ?? 'sm'}`);

const show = ref<boolean>(false);
const dialogRef = useTemplateRef('dialog');

const toggleBodyLock = (lock: boolean) => {
    document.documentElement.classList.toggle('overflow-hidden', lock);
};

watch(show, async (isVisible) => {
    if (isVisible) {
        toggleBodyLock(true);

        await nextTick();
        dialogRef.value?.showModal();
    }
});

onUnmounted(() => toggleBodyLock(false));

const handleClose = () => {
    show.value = false;
}

// Close dialog after leave transition to display whole animation
const handleAfterLeave = () => {
    dialogRef.value?.close();
    toggleBodyLock(false);
    emit('close');
};

defineExpose({ 
    show: () => show.value = true,
    close: handleClose
 });
</script>

<template>
    <dialog
        ref="dialog"
        class="backdrop:bg-gray-500/75 backdrop:transition-opacity bg-transparent overflow-visible m-0 p-0 max-w-none max-h-none w-full h-full border-none"
        @cancel="handleClose"
        @click.self="handleClose"
    >
        <div class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-start justify-center pointer-events-none">
            
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @after-leave="handleAfterLeave"
            >
                <div 
                    v-if="show" 
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all sm:w-full pointer-events-auto"
                    :class="maxWidthClass"
                >
                    <div class="px-6 py-4">
                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            <slot name="title"></slot>
                        </div>

                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            <slot name="content"></slot>
                        </div>
                    </div>

                    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-end">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </Transition>
        </div>
    </dialog>
</template>