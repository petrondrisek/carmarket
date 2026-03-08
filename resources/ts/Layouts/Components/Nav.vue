<script setup lang="ts">
import { computed, ref, useTemplateRef, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import NavLink from '@/Layouts/Components/NavLink.vue';
import Dropdown from '@/Modules/JetStream/Dropdown.vue';
import { useBreakpoints } from '@/Shared/Composables/useBreakpoints';
import { Breakpoints } from '@/Shared/Types/Breakpoints';
import { useClickOutside } from '@/Shared/Composables/useClickOutside';
import { PageProps } from '@/Shared/Types/PageProps';

const page = usePage<PageProps>();
const auth = computed(() => page.props.auth?.user || null);

// Responsive navigation
const { isMobile } = useBreakpoints(Breakpoints.lg);
const navShow = ref<boolean>(!isMobile.value);
const hamburgerOn = computed<boolean>(() => isMobile.value);
watch(isMobile, (mobile: boolean) => navShow.value = !mobile, { immediate: true });

// Navigation refs
const navRef = useTemplateRef('navRef');
const buttonNavOpenRef = useTemplateRef('buttonNavOpenRef');

// Actions
const toggleMenu = () => (navShow.value = !navShow.value);
const closeMenu = () => { if (isMobile.value) navShow.value = false; };
const logout = () => router.post(route('logout'));
useClickOutside([navRef, buttonNavOpenRef], closeMenu);
</script>

<template>
    <button
        ref="buttonNavOpenRef"
        v-if="hamburgerOn"
        class="block lg:hidden text-gray-500 hover:text-gray-600 focus:text-gray-600 focus:outline-none mr-4"
        @click="toggleMenu"
    >
        <svg
            class="h-6 w-6 fill-current hover:fill-gray-600 dark:fill-white dark:hover:fill-gray-400"
            viewBox="0 0 24 24"
        >
            <path
                v-if="!navShow"
                d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
            />
            <path
                v-else
                d="M6.016 5.135L5.135 6.016 12.047 12.928 5.135 19.84l0.881 0.881 6.912-6.912 6.912 6.912 0.881-0.881-6.912-6.912 6.912-6.912-0.881-0.881-6.912 6.912Z"
            />
        </svg>
    </button>

    <nav
        ref="navRef"
        v-show="navShow"
        class="flex items-center"
        :class="{
            'absolute z-40 w-full flex-col top-[72px] right-0 bg-gray-200 dark:bg-gray-800 text-black dark:text-white py-4': hamburgerOn
        }"
    >
        <NavLink routeName="app_dashboard" component="Dashboard" @link-clicked="closeMenu">
            Dashboard
        </NavLink>

        <NavLink routeName="app_car_get" component="Car/List" @link-clicked="closeMenu">
            List of cars
        </NavLink>

        <NavLink routeName="app_car_search" component="Car/Search/" @link-clicked="closeMenu">
            Search
        </NavLink>

        <NavLink v-if="auth === null" routeName="login" component="Auth/Login" @link-clicked="closeMenu">
            Log in
        </NavLink>

        <NavLink v-if="auth !== null" routeName="app_car_add" component="Car/Add" @link-clicked="closeMenu">
            Add new car
        </NavLink>

        <Dropdown v-if="auth !== null" :width="48">
            <template #trigger>
                <span
                    class="flex items-center gap-2 p-2 cursor-pointer text-sm hover:text-gray-600 hover:bg-primary-500 hover:text-white dark:hover:bg-gray-700 transition duration-150 ease-in-out rounded"
                >
                    <img class="size-7 rounded-full object-cover" :src="auth.profile_photo_url" :alt="auth.name" />
                    {{ auth.name }} &darr;
                </span>
            </template>

            <template #content>
                <NavLink
                    v-if="auth !== null && auth.permissions.includes('BRAND_MANAGE')"
                    routeName="app_brand_manage"
                    component="Brand/Manage"
                    @link-clicked="closeMenu"
                >
                    Manage brands
                </NavLink>
                <NavLink
                    routeName="profile.show"
                    component="Profile/Show"
                    class="flex items-center gap-2"
                    @link-clicked="closeMenu"
                >
                    Edit profile
                </NavLink>
                <NavLink v-if="auth !== null" routeName="#" :external="true" @click="logout">
                    Log out
                </NavLink>
            </template>
        </Dropdown>
    </nav>
</template>
