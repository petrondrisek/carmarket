<script lang="ts" setup>
const props = defineProps<{
    headers: string[]
}>();
</script>

<template>
    <table v-bind="$attrs" class="w-full border-2 border-gray-200 dark:border-gray-700">
        <thead>
            <tr>
                <th 
                    v-for="(header, index) in props.headers" 
                    :key="`header_${index}`" 
                    class="p-4 text-left text-gray-700 dark:text-gray-400"
                >
                    {{ header }}
                </th> 
            </tr>
        </thead>
        <tbody>
            <slot></slot>
        </tbody>
    </table>
</template>