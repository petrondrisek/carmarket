export interface BrandForm{
    _method: 'GET' | 'POST' | 'PUT' | 'DELETE';
    name: string,
    logo: File[] | File | null,
    description: string,
    is_active: boolean,
    [key: string]: any
}