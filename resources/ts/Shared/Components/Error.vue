<script setup lang="ts">
import { computed } from 'vue'

type LaravelErrors = Record<string, string[]>

type ErrorMessage =
  | string
  | string[]
  | LaravelErrors
  | null
  | undefined

const props = defineProps<{
  message: ErrorMessage
}>()

const normalizedErrors = computed(() => {
  if (!props.message) return []

  if (typeof props.message === 'string') {
    return [props.message]
  }

  if (Array.isArray(props.message)) {
    return props.message
  }

  if (typeof props.message === 'object') {
    return Object.values(props.message).flat()
  }

  return []
})
</script>

<template>
  <div v-if="normalizedErrors.length" 
       class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">

    <p
      v-for="(error, index) in normalizedErrors"
      :key="index"
      class="font-medium"
    >
      {{ error }}
    </p>

  </div>
</template>