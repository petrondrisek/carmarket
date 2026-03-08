<script setup lang="ts">
import { useToast } from "@/Modules/Toast/useToast";
import { ToastMessageType } from "@/Modules/Toast/toast.models";

const { messages } = useToast();
</script>

<template>
    <ul class="fixed flex flex-col gap-3 bottom-4 left-1/2 -translate-x-1/2 min-w-[320px] z-40">
        <li 
        v-for="toast in messages" 
        class="bg-slate-100 dark:bg-slate-800 w-[320px] md:w-[600px] lg:w-[800px] break-word text-black rounded p-2 border-2 border-gray-300 dark:border-gray-700 dark:text-white relative">
            {{ toast.message }}

            <div 
            class="absolute left-0 bottom-0 h-[2px] rounded animate-progress"
            :style="{ animationDuration: Math.floor(toast.timeout / 1000) + 's' }"
            :class="{
                'bg-green-500': toast.type === ToastMessageType.SUCCESS,
                'bg-red-500': toast.type === ToastMessageType.DANGER,
                'bg-yellow-500': toast.type === ToastMessageType.WARNING,
                'bg-gray-500': toast.type === ToastMessageType.INFO,
            }"
            ></div>
        </li>
    </ul>
</template>