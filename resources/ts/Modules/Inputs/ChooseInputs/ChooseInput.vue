<script lang="ts" setup generic="T extends Record<string, any>">
import { onMounted, useTemplateRef } from 'vue';
import { useClickOutside } from '@/Shared/Composables';
import { useChoose } from './useChoose';

const props = defineProps<{
    items: T[],
    initialIndex?: number
}>();

const emit = defineEmits<{
    (e: 'selected', item: T): void
}>();

const { 
    visible, 
    setVisible,
    selectedIndex,
    setSelectedIndex,
    onKeyDown
} = useChoose(props.items, props.initialIndex, (item: T) => emit('selected', item));

const selectRef = useTemplateRef('selectRef');
useClickOutside([selectRef], () => setVisible(false));

defineExpose({
    setSelectedIndex
});

onMounted(() => {
    if (props.items.length > 0) {
        setSelectedIndex(props.initialIndex ?? 0);
    }
});
</script>

<template>
    <div class="w-full relative" ref="selectRef">
        <div
            v-bind="$attrs"
            tabindex="0"
            @keydown="onKeyDown"
            @click="setVisible(!visible)" 
            class="bg-white dark:bg-gray-900 rounded border-2 border-gray-300 dark:border-gray-700 p-2 relative cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 focus:border-primary-500 outline-none transition-colors"
        >
            <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                {{ visible ? '▲' : '▼' }}
            </span>
            
            <slot name="errors"></slot>

            <slot name="option" :item="props.items[selectedIndex] ?? null"></slot>
        </div>

        <div 
            v-if="visible" 
            class="absolute z-50 w-full bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 rounded mt-1 max-h-48 overflow-y-auto shadow-xl"
        >
            <div 
                v-for="(item, index) in props.items" 
                :key="'item-' + index" 
                class="transition-colors" 
                :class="{ 
                    'bg-primary-500 text-white': index == selectedIndex,
                    'hover:bg-gray-100 dark:hover:bg-gray-700': index != selectedIndex
                }"
                @click.stop="setSelectedIndex(index)"
            >
                <label :for="'item-option-' + index" class="flex p-2 cursor-pointer items-center w-full">
                    <slot name="option" :item="item"></slot>
                </label>

                <input 
                    type="radio" 
                    :id="'item-option-' + index" 
                    :value="index"
                    :checked="index === selectedIndex"
                    class="hidden"
                >
            </div>
        </div>
    </div>
</template>