<script setup lang="ts">
interface Props {
    min?: number;
    max?: number;
    step?: number;
    breakpoints?: number[];
    stateAlign?: 'left' | 'right';
    unit?: string;
}

const props = withDefaults(defineProps<Props>(), {
    min: 0,
    max: 100,
    step: 1,
    breakpoints: () => [],
    stateAlign: 'right',
    unit: ''
});

const model = defineModel<number>();

const getPosition = (val: number) => {
    const percentage = ((val - props.min) / (props.max - props.min)) * 100;

    return Math.min(Math.max(percentage, 0), 100);
};

const displayValue = (val: number) => `${val} ${props.unit}`;
</script>

<template>
    <div class="flex justify-between items-center flex-wrap mb-4">
        <input 
            v-if="stateAlign === 'left'" 
            type="text" 
            :disabled="true" 
            v-model="model" 
            class="w-max dark:bg-gray-700 dark:text-gray-100 text-center" 
        />

        <div class="relative mb-6 w-full md:w-4/5">
            <label for="range-input" class="sr-only">Labels range</label>

            <input 
                v-bind="$attrs" 
                id="range-input" 
                type="range" 
                v-model="model" 
                :step="step" 
                :min="min" 
                :max="max" 
                class="w-full h-2 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
            >
            
            <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">
                {{ displayValue(props.min) }}
            </span>
            
            <span 
                v-for="bp in breakpoints" 
                :key="bp" 
                :style="{left: `${getPosition(bp)}%`}" 
                class="text-sm text-gray-500 dark:text-gray-400 absolute -bottom-6"
            >
                {{ displayValue(bp) }}
            </span>
            
            <span class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">
                {{ displayValue(props.max) }}
            </span>
        </div>

        <input 
            v-if="stateAlign === 'right'" 
            type="text" disabled 
            v-model="model"
            class="bg-gray-200 dark:bg-gray-700 dark:text-gray-100 text-center hidden md:block w-full md:w-1/6" 
        />   
</div>
</template>