<script setup lang="ts">
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { SwiperGallery, SwiperFullscreen } from '@/Modules/Swiper';
import { CarActionPanel, CarHero, CarDetail } from '@/Modules/Car';
import { BrandDetail } from '@/Modules/Brand';
import { PageProps } from '@/Shared/Types';
import { PrimaryButton, Link, Error } from '@/Shared/Components';

const page = usePage<PageProps>();
const car = page.props.car;
const user = page.props.auth?.user;

const showFullscreen = ref(false)

const scrollDown = (elementSelector: string) => {
    const detailInfo = document.querySelector(elementSelector);
    const rect = detailInfo?.getBoundingClientRect();
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    window.scrollTo({
        top: scrollTop + (rect?.top || 0),
        left: 0,
        behavior: 'smooth'
    });
};
</script>

<template>
    <Head :title="`${car?.brand.name ?? 'X'} - ${car?.model ?? 'Y'} | Detail`"></Head>

    <Error v-if="car === null" message="Car not found" />

    <div v-else>
        <Error message="This offer is no longer available." />

        <CarActionPanel v-if="user !== undefined && user !== null" :car="car" :user="user" />

        <CarHero :car="car">
            <template #gallery>
                <button v-if="car.images.length > 0" class="text-4xl cursor-pointer absolute bottom-32 right-4 z-10" @click="showFullscreen = true">
                    <svg height="32px" viewBox="0 0 24 24" width="32px" class="stroke-white hover:stroke-gray-400 fill-white hover:fill-gray-400 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg"><title/><g id=Complete><g id=expand><g><polyline data-name=Right id=Right-2 points="3 17.3 3 21 6.7 21" stroke-linecap=round stroke-linejoin=round stroke-width=2 /><line stroke-linecap=round stroke-linejoin=round stroke-width=2 x1=10 x2=3.8 y1=14 y2=20.2 /><line stroke-linecap=round stroke-linejoin=round stroke-width=2 x1=14 x2=20.2 y1=10 y2=3.8 /><polyline data-name=Right fill=none id=Right-3 points="21 6.7 21 3 17.3 3" stroke-linecap=round stroke-linejoin=round stroke-width=2 /></g></g></g></svg>
                </button>

                <SwiperGallery v-if="car.images.length > 0" :images="car.images" />
            </template>

            <template #short-description>
                <Link
                    v-if="car.description.length > 200"
                    @click.prevent="() => scrollDown('.detail-info-text')"
                >
                        Read more
                </Link>
            </template>

            <template #buttons>
                <PrimaryButton @click.prevent="() => scrollDown('.detail-info')">
                    More details    
                </PrimaryButton>
            </template>
        </CarHero>

        <CarDetail :car="car" :brand="car.brand">
            <template #brand-actions>
                <Link @click.prevent="() => scrollDown('.detail-info-brand')">About brand</Link>
            </template>
        </CarDetail>
        
        <BrandDetail v-if="car.brand !== null" :brand="car.brand"/>
        <SwiperFullscreen v-if="car.images.length > 0" :show="showFullscreen" @close="showFullscreen = false" :images="car.images" />
        </div>
</template>

<script lang="ts">
export default { 
    layout: Layout 
};
</script>