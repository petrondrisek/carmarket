import { Ref } from "vue"

export interface ToastInterface {
    messages: Ref<ToastMessage[]>,
    addToastMessage: (message: string, type?: ToastMessageType, timeout?: number | null) => void
}

export type ToastMessage = {
    id: string,
    type: ToastMessageType,
    message: string,
    timeout: number
}

export enum ToastMessageType {
    SUCCESS = 'success',
    DANGER = 'danger',
    WARNING = 'warning',
    INFO = 'info'
}