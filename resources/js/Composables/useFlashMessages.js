import { watch, toRaw } from 'vue';
import { useToast } from "@/Composables/useToast";

export function useFlashMessages( props ) {
    const { addToastMessage } = useToast();

    watch(() => props.errors, (errors) => {
        if (!errors || typeof errors !== 'object' || !Object.keys(errors).length) 
            return;
    
        Object.keys(errors).forEach(key => {
            const value = Array.isArray(errors[key]) ? errors[key].join(', ') : errors[key];

            addToastMessage(`${key}: ${value}`, 'danger');
        });

        console.error(toRaw(errors));
    }, { immediate: true });
    
    watch(() => props.success, (success) => {
        if( success ) {
            addToastMessage(success, 'success');
        }
    }, { immediate: true });

    const Success = (message, timeoutMs = 3000) => {
        addToastMessage(message, 'success', timeoutMs);
    }

    return { Success };
}