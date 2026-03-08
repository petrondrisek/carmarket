<script lang="ts" setup>
    const { amount } = defineProps<{ amount: number }>();
</script>

<template>
    <span v-bind="$attrs" class="font-bold text-primary-500 dark:text-dark_primary-500">
        {{ new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK' }).format(amount) }}
    </span>
</template>