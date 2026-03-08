import { User } from "./User";

export enum UserPermission {
    USER = 'user',
    BRAND = 'BRAND_MANAGE',
    CAR = 'CAR_MANAGE'
}

export const hasUserPermission = (user: User, permission: UserPermission): boolean => {
    return user.permissions.includes(permission);
}