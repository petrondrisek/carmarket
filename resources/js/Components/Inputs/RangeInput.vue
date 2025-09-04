<script setup>
import { computed, toRefs } from 'vue';

const props = defineProps({
    min: {type: Number, default: 0},
    max: {type: Number, default: 100},
    step: {type: Number, default: 1},
    modelValue: {type: String, default: '1'},
    breakpoints: {type: Array, default: []},
    stateAlign: {type: String, default: 'left', validator: (v) => ['left', 'right'].includes(v)},
    unit: {type: String, default: '%'}
});

const emit = defineEmits([
    'update:modelValue',
    'change'
]);

const { min, max, step, breakpoints, stateAlign, unit } = toRefs(props);

const value = computed({
  get: () => props.modelValue,
  set: (val) => {
    emit('update:modelValue', val)
  }
})
</script>

<template>
    <div class="flex justify-between items-center flex-wrap mb-4">
        <input 
        v-if="stateAlign === 'left'" 
        type="text" disabled 
        :value="value" 
        class="w-max dark:bg-gray-700 dark:text-gray-100 text-center" />

        <div class="relative mb-6 w-full md:w-4/5">
            <label for="range-input" class="sr-only">Labels range</label>
            <input 
            v-bind="$attrs" 
            id="range-input" 
            type="range" 
            v-model="value" 
            :step="step" 
            :min="min" 
            :max="max" 
            class="w-full h-2 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
            @change="$emit('change', $event)"
            >
            
            <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">{{ min }} {{ unit }}</span>
            
            <span 
            v-for="breakpoint in breakpoints" 
            :key="breakpoint" 
            :style="{left: `${(breakpoint - Number(min)) / (Number(max) - Number(min)) * 100}%`}" 
            class="text-sm text-gray-500 dark:text-gray-400 absolute -bottom-6">
                {{ breakpoint }} {{ unit }}
            </span>
            
            <span class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">{{ max }} {{ unit }}</span>
        </div>

        <input 
        v-if="stateAlign === 'right'" 
        type="text" disabled 
        :value="value" 
        class="bg-gray-200 dark:bg-gray-700 dark:text-gray-100 text-center hidden md:block w-full md:w-1/6" />   
</div>
</template>

<script>
export default { inheritAttrs: false };
</script>