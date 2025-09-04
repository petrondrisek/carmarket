import { inject, ref, provide } from "vue";

export const TOAST_SYMBOL = Symbol("toast");

export function provideToast() {
    const messages = ref([]);

    const addToastMessage = (message, type = "info", timeout = null) => {
        let id = Math.random().toString(36).slice(2);

        let types = ["info", "success", "warning", "danger"];
        if(types.indexOf(type) === -1) {
            throw new Error("Invalid type for toast message. Must be one of: " + types.join(", "));
        }

        messages.value.push({ id, type, message, timeout: timeout ?? 3000 });

        setTimeout(() => {
            messages.value = messages.value.filter((m) => m.id !== id);
        }, timeout ?? 3000);
    }

    provide(TOAST_SYMBOL, {
        messages,
        addToastMessage
    });
}

export function useToast() {
    let toast = inject(TOAST_SYMBOL);

    if (!toast) {
        throw new Error("useToast() called outside setup");
    }
    
    return toast;
}