import { computed } from "vue";
import DOMPurify from 'dompurify';

export function useSafeHtml(content: string) {
    const safeHtmlContent = computed(() => DOMPurify.sanitize(content));

    return safeHtmlContent;
}