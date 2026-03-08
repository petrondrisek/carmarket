export type User = {
    id: number;
    name: string;
    email: string;
    profile_photo_url: string;
    profile_photo_path: string;
    permissions: string[];
    two_factor_enabled: boolean;
    first_name: string;
    last_name: string;
    phone: string;
    email_verified_at: string;
    photo?: File;
}