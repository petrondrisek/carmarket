export default function buildUrl(encode, data, page) {
    data.page = page;
    if(!encode) return data
    
    const cleanQuery = Object.fromEntries(Object.entries(data).filter(([_, v]) => v !== null && v !== 0));
    return { q: btoa(encodeURIComponent(JSON.stringify(cleanQuery))) };
}