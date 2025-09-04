<script setup>
import { computed, ref, toRefs, onMounted } from 'vue';

const props = defineProps({
    modelValue: {type: String, default: null},
    colors: {type: Object, default: {
        "Unselected": null,
        "Black": "#000000",
        "White": "#FFFFFF",
        "Silver": "#C0C0C0",
        "Gray": "#808080",
        "Red": "#FF0000",
        "Blue": "#0000FF",
        "Green": "#008000",
        "Yellow": "#FFFF00",
        "Orange": "#FFA500",
        "Brown": "#8B4513",
        "Beige": "#F5F5DC",
        "Gold": "#FFD700",
        "Purple": "#800080",
        "Pink": "#FFC0CB",
        "Maroon": "#800000",
        "Navy": "#000080",
        "Teal": "#008080",
        "Olive": "#808000",
        "Cyan": "#00FFFF",
        "Magenta": "#FF00FF",
        "Champagne": "#F7E7CE",
        "Bronze": "#CD7F32",
        "Turquoise": "#40E0D0",
        "Charcoal": "#36454F"
    }}
});

const selectedValue = ref(null);
const chooseShow = ref(false);
const { colors: colorsStack } = toRefs(props);
const color = computed({
    get: () => props.modelValue,
    set: (val) => {
        if (props.modelValue !== val) {
            emit('update:modelValue', val);
        }

        selectedValue.value = Object.keys(colorsStack.value).find(k => colorsStack.value[k] === val);
        chooseShow.value = false;
    }
});

const emit = defineEmits([
    'update:modelValue'
]);

const onKeyDown = (e) => {
    e.preventDefault();

    let selectedIndex = Object.keys(colorsStack.value).indexOf(selectedValue.value);
    let keys = Object.keys(colorsStack.value);

    // Down / Right
    if((e.key === 'ArrowDown' || e.key === 'ArrowRight') && selectedIndex + 1 < keys.length) {
        selectedValue.value = keys[selectedIndex + 1];
        color.value = colorsStack.value[selectedValue.value];
    }

    // Up / Left
    if((e.key === 'ArrowUp' || e.key === 'ArrowLeft') && selectedIndex > 0) {
        selectedValue.value = keys[selectedIndex - 1];
        color.value = colorsStack.value[selectedValue.value]; 
    }
}

onMounted(() => {
    let keys = Object.keys(colorsStack.value);

    if(!color.value) {
        color.value = colorsStack.value[keys[0]];
        selectedValue.value = keys[0];
    } else {
        let key = Object.entries(colorsStack.value).find(([_, val]) => val === color.value)?.[0];
        color.value = colorsStack.value[key];
        selectedValue.value = key;
    }
});
</script>

<template>
    <div
        tabindex="0"
        @keydown="onKeyDown"
        @click="chooseShow = !chooseShow" 
        class="bg-white dark:bg-gray-900 rounded border-2 border-gray-300 dark:border-gray-700 p-2 relative cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800"
    >
        <span class="absolute right-0 top-0 m-2 text-gray-400">{{ chooseShow ? '&uarr;' : '&darr;' }}</span>
        <span class="flex items-center gap-1">
            <div class="w-6 h-6 rounded-full bg-gray-200 border-2 border-gray-300 dark:border-gray-700" :style="{backgroundColor: colorsStack[selectedValue]}"></div>
            {{ selectedValue }}
        </span>
    </div>
    <div v-show="chooseShow" class="bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded max-h-40 overflow-y-auto">
        <div 
        v-for="col in Object.keys(colorsStack)" 
        :key="col" 
        class="mt-1 rounded" 
        :class="{ 
            'bg-primary-500 dark:bg-dark_primary-500 text-white hover:bg-primary-500': col == selectedValue,
            'hover:bg-gray-200 dark:hover:bg-gray-600': col != selectedValue
        }"
        >
            <label :for="'color-' + col" class="flex p-2 cursor-pointer items-center gap-1">
                <div class="w-6 h-6 rounded-full bg-gray-200 border-2 border-gray-300 dark:border-gray-700" :style="{backgroundColor: colorsStack[col] }"></div>
                {{ col }}
            </label>
            <input 
            v-model="color" 
            type="radio" 
            :id="'color-' + col" 
            :value="colorsStack[col]"
            class="hidden"
            v-bind="$attrs"
            >
        </div>
    </div>
</template>

<script>
export default { inheritAttrs: false };
</script>