<script setup lang="ts">
const props = defineProps<{
    header: string
}>();
</script>

<template>
    <tr class="border-y-2 border-gray-200 dark:border-gray-700">
        <th class="p-4 text-left text-gray-700 dark:text-gray-400">
            {{ props.header }}
        </th>

        <td class="p-4">
            <slot></slot>
        </td>
    </tr>
</template>