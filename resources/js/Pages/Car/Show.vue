<script setup>
import { ref } from 'vue';
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue';
import SecondaryButton from '@/Components/Forms/SecondaryButton.vue';
import DialogModal from '@/Components/Modal/DialogModal.vue';
import { useFlashMessages } from '@/Composables/useFlashMessages';
import SwiperGallery from '@/Components/SwiperGallery/SwiperGallery.vue';
import SwiperFullScreen from '@/Components/SwiperGallery/SwiperFullScreen.vue';

const page = usePage();
const car = ref(page?.props?.car ?? {});
const images = ref(JSON.parse(car.value.images ?? "[]").map(image => '/storage/' + image));
const otherFeatures = ref(JSON.parse(car.value.other_features ?? "{}"));
const brand = ref(page?.props?.brand ?? {});
const user = ref(page?.props?.auth?.user ?? null);
const userPermission = ref(JSON.parse(user.value?.permissions ?? "[]"));
const showFullscreen = ref(false);

const deleteCarModal = ref(false);
const form = useForm({});
const { Success } = useFlashMessages( form );

const deleteCar = (e) => {
    e.preventDefault();

    deleteCarModal.value = false;

    form.delete(route('app_car_delete', { car: car.value.id }, {
        onSuccess: () => {
            Success('Car deleted successfully');
            router.visit(route('app_car_list'));
        }
    }));
}

const scrollDown = (elementSelector) => {
    const detailInfo = document.querySelector(elementSelector);
    const rect = detailInfo.getBoundingClientRect();
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    window.scrollTo({
        top: scrollTop + rect.top,
        left: 0,
        behavior: 'smooth'
    });
};

const soldCar = (e) => {
    e.preventDefault();

    form.post(route('app_car_sold', { car: car.value.id }), { onSuccess: () => {
        Success('Car marked as sold successfully');
    }});
}
</script>

<template>
    <Head :title="`${brand.name ?? 'X'} - ${car.model ?? 'Y'} | Detail`"></Head>

    <div v-if="car.is_sold" class="shadow-md bg-red-600 text-white rounded-md p-3 mb-4">
        <p>Tato nabídka již není aktivní.</p>
    </div>

    <div v-if="user" class="flex items-center justify-end gap-2 w-full mb-4">
        <primary-button 
            v-if="!car.is_sold && (userPermission.includes('CAR_MANAGE') || user.id == car.user.id)" 
            @click="soldCar"
        >
            Mark as sold
        </primary-button>

        <primary-button 
            v-if="userPermission.includes('CAR_MANAGE')" 
            @click="() => router.visit(route('app_car_edit', { carId: car.id }))"
        >
            Edit car
        </primary-button>
        
        <primary-button 
            v-if="userPermission.includes('CAR_MANAGE')" as="button" 
            @click="deleteCarModal = true"
        >
            Delete car
        </primary-button>
        
        <dialog-modal v-if="userPermission.includes('CAR_MANAGE')" :show="deleteCarModal">
            <template #title>Delete car</template>

            <template #content>Are you sure you want to delete this car?</template>

            <template #footer>
                <primary-button @click="deleteCar">Delete</primary-button>

                <secondary-button @click="deleteCarModal = false">Cancel</secondary-button>
            </template>
        </dialog-modal>
    </div>

    <div class="shadow-md rounded-md bg-white dark:bg-gray-800 p-3">
        <div class="grid grid-cols-3 relative">
            <div class="gallery max-w-[100%] col-span-3 lg:col-span-2 relative">
                <button class="text-4xl cursor-pointer absolute bottom-32 right-4 z-10" @click="showFullscreen = true">
                    <svg height="32px" viewBox="0 0 24 24" width="32px" class="stroke-white hover:stroke-gray-400 fill-white hover:fill-gray-400 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg"><title/><g id=Complete><g id=expand><g><polyline data-name=Right id=Right-2 points="3 17.3 3 21 6.7 21" stroke-linecap=round stroke-linejoin=round stroke-width=2 /><line stroke-linecap=round stroke-linejoin=round stroke-width=2 x1=10 x2=3.8 y1=14 y2=20.2 /><line stroke-linecap=round stroke-linejoin=round stroke-width=2 x1=14 x2=20.2 y1=10 y2=3.8 /><polyline data-name=Right fill=none id=Right-3 points="21 6.7 21 3 17.3 3" stroke-linecap=round stroke-linejoin=round stroke-width=2 /></g></g></g></svg>
                </button>
                <swiper-gallery v-if="images.length > 0" :images="images" />
            </div>

            <div class="base-info col-span-3 lg:col-span-1 p-4 grid grid-cols-1">
                <div class="base-info__header">
                    <h1 class="text-3xl font-semibold">
                        {{ brand.name ?? 'Unknown brand' }} - {{ car.model ?? 'Unknown model' }}
                    </h1>
                    <p>{{ car.kilometers }} km &bull; {{ car.year }} &bull; {{ car.city_name }}</p>
                </div>

                <p class="my-6 row-span-12">
                    {{ car.description.replace(/(<([^>]+)>)/ig, "").slice(0, 300) }}
                    {{ car.description.length > 300 ? '...' : '' }}
                    <a 
                        v-if="car.description.length > 300"
                        class="text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400" 
                        href="#" 
                        @click.prevent="() => scrollDown('.detail-info-text')">
                            Read more
                    </a>
                </p>
                
                <p class="text-primary-500 dark:text-dark_primary-500 font-extrabold text-4xl text-right">
                    {{ new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK' }).format(car.price)}}
                </p>

                <button 
                    class="mt-2 bg-primary-500 dark:bg-dark_primary-500 px-4 py-2 rounded-md text-white font-semibold text-sm hover:bg-primary-600 dark:hover:bg-dark_primary-600 transition ease-in-out duration-150"
                    @click.prevent="() => scrollDown('.detail-info')"
                >
                    More details    
                </button>
            </div>
        </div>
    </div>

    <h2 class="mt-4 text-2xl font-semibold detail-info">Detail info</h2>
    <table class="mt-2 w-full border-2 border-gray-200 dark:border-gray-700">
        <tbody>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Location</th>
                <td class="p-4">{{ car.city_name }} (Lat: {{ car.locationLat }}, Long: {{ car.locationLng }})</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Color</th>
                <td class="p-4"><div class="w-6 h-6 rounded-full border-2 border-gray-200 dark:border-gray-700" :style="{ 'background-color': car.color }"></div></td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Brand</th>
                <td class="p-4">
                    {{ brand.name ?? 'Unknown brand' }} - <a 
                        class="text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400"
                        href="#" 
                        @click.prevent="() => scrollDown('.detail-info-brand')">
                            About brand
                    </a>
                </td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Year</th>
                <td class="p-4">{{ car.year }}</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">State</th>
                <td class="p-4">{{ car.state.charAt(0).toUpperCase() + car.state.slice(1) }}</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Kilometers</th>
                <td class="p-4">{{ car.kilometers }} km</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Engine</th>
                <td class="p-4">{{ car.engine.charAt(0).toUpperCase() + car.engine.slice(1) }}</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Transmission</th>
                <td class="p-4">{{ car.transmission.charAt(0).toUpperCase() + car.transmission.slice(1) }}</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Fuel consumption</th>
                <td class="p-4">{{ car.fuel_consumption }} l/100km</td>
            </tr>
            <tr v-for="(field, key) in otherFeatures" :key="key" class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">{{ key.charAt(0).toUpperCase() + key.slice(1) }}</th>
                <td class="p-4">{{ field.charAt(0).toUpperCase() + field.slice(1) }}</td>
            </tr>
            <tr class="border-y-2 border-gray-200 dark:border-gray-700">
                <th class="p-4 text-left">Seller</th>
                <td class="p-4">
                    <p v-if="car.user.last_name">{{ car.user.name }} - {{ car.user.first_name ?? '' }} {{ car.user.last_name ?? '' }}</p>
                    <p v-else>{{ car.user.name }}</p>
                    <p>
                        <b>Phone</b>: 
                        <a :href="'tel:' + car.user.phone" v-if="car.user.phone" class="text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400">{{ car.user.phone }}</a> 
                        <span v-else>-</span>
                    </p>
                    <p><b>Email</b>: <a :href="'mailto:' + car.user.email" class="text-primary-500 dark:text-dark_primary-500 hover:text-primary-400 dark:hover:text-dark_primary-400">{{ car.user.email }}</a></p>
                </td>
            </tr>
        </tbody>
    </table>
    <h2 class="mt-4 text-2xl font-semibold detail-info-text">Description</h2>
    <p v-if="car.description.length > 200" class="mt-2" v-html="car.description">       
    </p>

    <h2 class="mt-4 text-2xl font-semibold detail-info-brand">About the brand {{ brand.name ?? 'Unknown brand' }}</h2>
    <div class="grid grid-cols-4 gap-4">
        <img v-if="brand.logo" :src="`/storage/${brand.logo}`" class="w-40 mx-auto col-span-4 md:col-span-1" :alt="brand.name" />
        <p class="mt-2 col-span-4 md:col-span-3" v-html="brand.description ?? 'No description'">
        </p>
    </div>
    <swiper-full-screen v-if="images.length > 0" :show="showFullscreen" @close="showFullscreen = false" :images="images" />
</template>

<script>
export default { 
    layout: Layout 
};
</script>