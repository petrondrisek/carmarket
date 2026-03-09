<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ThemeSwitcher} from '@/Modules/Theme';
import { provideToast, ToastMessages } from '@/Modules/Toast';
import { Nav } from './Components';

interface Props {
    title?: string
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Page',
})

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

provideToast();
</script>

<template>
    <Head :title="`${props.title} | ${appName}`"></Head>

    <header class="max-w-7xl mx-auto mt-4 lg:mt-0 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <Link :href="route('app_dashboard')" class="flex items-center">
            <img src="/images/logo.png" alt="Logo" width="48px">
            <h1 class="text-2xl text-primary-500 font-bold dark:text-dark_primary-500">{{ appName }}</h1>
        </Link>

        <div class="flex items-center gap-2">
            <Nav></Nav>
            <ThemeSwitcher></ThemeSwitcher>
        </div>
    </header>

    <main class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <ToastMessages />
        <slot></slot>
    </main>

    <footer class="mt-8 px-4 sm:px-6 lg:px-8 border-t-2 border-gray-300 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-8">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ new Date().getFullYear() }} {{ appName }} | Petr Ondříšek | All rights reserved
            </p>
        </div>
    </footer>
</template>

<script lang="ts">
    // @ts-ignore - Google Maps API
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "AIzaSyC6_qSkmxjCRqtU3IT_22Ba_do-GkqAJAc",
        v: "weekly"
    });
</script>