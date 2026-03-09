export const stripHtml = (html: string): string => {
    if (typeof window === 'undefined') return html.replace(/<[^>]*>?/gm, '');

    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};