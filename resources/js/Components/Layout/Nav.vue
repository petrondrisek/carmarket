<script setup>
import NavLink from './NavLink.vue';
import { throttle } from 'lodash';
import { computed, onMounted, onUnmounted, ref, useTemplateRef, nextTick } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Dropdown from '../Dropdown/Dropdown.vue';

const breakpoint = 1024;
const page = usePage();

const navRef = useTemplateRef('navRef');
const buttonNavOpenRef = useTemplateRef('buttonNavOpenRef');
const navShow = ref(window.innerWidth >= breakpoint);
const hamburgerOn = ref(window.innerWidth < breakpoint);
const auth = computed(() => page.props.auth?.user);

const checkWindowWidth = throttle(() => {
    if (window.innerWidth >= breakpoint) {
        hamburgerOn.value = false;
        navShow.value = true;
    } else {
        hamburgerOn.value = true;
        navShow.value = false;
    }
}, 150);


const toggleMenu = async (e) => {
    e.stopPropagation();
    navShow.value = !navShow.value;
    await nextTick();
};

const closeMenuOnClickOutside = (e) => {
    if (!hamburgerOn.value) return;
    if (
        !navRef.value.contains(e.target) &&
        !buttonNavOpenRef.value.contains(e.target)
    ) {
        navShow.value = false;
    }
};

const handleNavLinkClick = () => {
    if (hamburgerOn.value) {
        navShow.value = false;
    }
};

const logout = () => {
    handleNavLinkClick();
    router.post(route('logout'));
};

onMounted(() => {
    window.addEventListener('resize', checkWindowWidth);
    document.addEventListener('click', closeMenuOnClickOutside);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkWindowWidth);
    document.removeEventListener('click', closeMenuOnClickOutside);
});
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
        <NavLink routeName="app_dashboard" component="Dashboard" @link-clicked="handleNavLinkClick">
            Dashboard
        </NavLink>

        <NavLink routeName="app_car_get" component="Car/List" @link-clicked="handleNavLinkClick">
            List of cars
        </NavLink>

        <NavLink routeName="app_search" component="SearchMap" @link-clicked="handleNavLinkClick">
            Search
        </NavLink>

        <NavLink v-if="auth === null" routeName="login" component="Auth/Login" @link-clicked="handleNavLinkClick">
            Log in
        </NavLink>

        <NavLink v-if="auth !== null" routeName="app_car_add" component="Car/Add" @link-clicked="handleNavLinkClick">
            Add new car
        </NavLink>

        <Dropdown v-if="auth !== null" width="48">
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
                    @link-clicked="handleNavLinkClick"
                >
                    Manage brands
                </NavLink>
                <NavLink
                    routeName="profile.show"
                    component="Profile/Show"
                    class="flex items-center gap-2"
                    @link-clicked="handleNavLinkClick"
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
