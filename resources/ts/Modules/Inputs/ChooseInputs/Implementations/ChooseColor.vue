<script setup lang="ts" generic="T extends string">
import ChooseInput from '../ChooseInput.vue';

interface Item {
    label: string;
    value: string;
}

const items: Item[] = [
    {label: "Unselected", value: ""},
    {label: "Black", value: "#000000"},
    {label: "White", value: "#FFFFFF"},
    {label: "Silver", value: "#C0C0C0"},
    {label: "Gray", value: "#808080"},
    {label: "Red", value: "#FF0000"},
    {label: "Blue", value: "#0000FF"},
    {label: "Green", value: "#008000"},
    {label: "Yellow", value: "#FFFF00"},
    {label: "Orange", value: "#FFA500"},
    {label: "Brown", value: "#8B4513"},
    {label: "Beige", value: "#F5F5DC"},
    {label: "Gold", value: "#FFD700"},
    {label: "Purple", value: "#800080"},
    {label: "Pink", value: "#FFC0CB"},
    {label: "Maroon", value: "#800000"},
    {label: "Navy", value: "#000080"},
    {label: "Teal", value: "#008080"},
    {label: "Olive", value: "#808000"},
    {label: "Cyan", value: "#00FFFF"},
    {label: "Magenta", value: "#FF00FF"},
    {label: "Champagne", value: "#F7E7CE"},
    {label: "Bronze", value: "#CD7F32"},
    {label: "Turquoise", value: "#40E0D0"},
    {label: "Charcoal", value: "#36454F"}
];

const [model] = defineModel<string | null>({ default: null });
const initialColorIndex = items.findIndex(item => item.value === model.value);
</script>

<template>
    <ChooseInput
        :items="items || []"
        :initial-index="initialColorIndex"
        @selected="(item: Item) => model = item.value"
    >
        <template #option="{ item }: { item: Item | null }">
            <span 
                v-if="item !== null" 
                class="inline-block w-5 h-5 rounded-full mr-2" 
                :style="{ backgroundColor: item.value }"
            ></span>
            {{ item?.label }}
        </template>
    </ChooseInput>
</template>