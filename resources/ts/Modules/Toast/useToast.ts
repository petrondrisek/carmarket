import { inject, ref, provide, onUnmounted, Ref } from "vue";
import { ToastInterface, ToastMessage, ToastMessageType } from "@/Modules/Toast/toast.models";

export const TOAST_SYMBOL = Symbol("toast");

export function provideToast() {
    const messages = ref<ToastMessage[]>([]);
    const timers = new Set<ReturnType<typeof setTimeout>>();

    const addToastMessage = (
        message: string, 
        type: ToastMessageType = ToastMessageType.INFO, 
        timeout: number | null = null
    ) => {
        const id = crypto.randomUUID?.() || Math.random().toString(36).slice(2);
        const duration = timeout ?? 3000;

        const validTypes = Object.values(ToastMessageType);
        const finalType = validTypes.includes(type as ToastMessageType) 
            ? (type as ToastMessageType) 
            : ToastMessageType.INFO;

        messages.value.push({ 
            id, 
            type: finalType, 
            message, 
            timeout: duration
        });

        if (typeof window !== 'undefined') {
            const timer = setTimeout(() => {
                messages.value = messages.value.filter(m => m.id !== id);
                timers.delete(timer);
            }, duration);
            timers.add(timer);
        }
    }

    onUnmounted(() => {
        timers.forEach(t => clearTimeout(t as number));
        timers.clear();
    });

    const returns = { messages, addToastMessage };
    provide(TOAST_SYMBOL, returns);

    return returns;
}

export function useToast() {
    const toast = inject<ToastInterface>(TOAST_SYMBOL);

    if (!toast) {
        throw new Error("useToast() must be used within a provideToast() provider");
    }
    
    return toast;
}