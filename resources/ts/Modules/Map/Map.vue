<script setup lang="ts">
import { onMounted, onUnmounted, useTemplateRef, watch } from 'vue';
import { useGoogleMaps } from './useGoogleMaps';
import { useTheme, Theme } from '@/Modules/Theme';

const lat = defineModel<number>('lat', { default: 50.032 });
const lng = defineModel<number>('lng', { default: 15.779 });
const city = defineModel<string>('city', { default: 'Pardubice' });
const radius = defineModel<number>('radius', { default: 10 });

const mapRef = useTemplateRef('mapRef');
const { 
    updateMapTheme,
    updatePositionWithoutEffect,
    updateRadius,
    initMap, 
    initMarker, 
    initCircle, 
    destroy 
} = useGoogleMaps(
    (newLat: number, newLng: number) => {
        lat.value = newLat;
        lng.value = newLng;
    }, // update location
    (newCity: string) => city.value = newCity // update city
);

watch([lat, lng], ([newLat, newLng]) => {
    updatePositionWithoutEffect(newLat, newLng);
});

watch(radius, (newRadius) => {
    updateRadius(newRadius);
});

const { theme } = useTheme();
watch(theme, (newTheme: Theme) => {
    updateMapTheme(newTheme === Theme.Dark ? 'DARK' : 'LIGHT');
})

onMounted(async () => {
    try {
        await initMap(
            mapRef.value as HTMLDivElement, 
            {
                center: { lat: lat.value, lng: lng.value },
                zoom: 7,
                mapId: "6e6e8cdb4240be66513b73ab",
                clickableIcons: false,
                colorScheme: theme.value === Theme.Dark ? 'DARK' : 'LIGHT'
            }, 
            { lat: lat.value, lng: lng.value }
        );

        await initMarker({ lat: lat.value, lng: lng.value });

        await initCircle(radius.value * 1000, '#FF0000');
    } catch (error) {
        console.error('Error initializing Google Map:', error);
    }
});

onUnmounted(() => {
    destroy();
});
</script>

<template>
    <div ref="mapRef" class="w-full h-[320px]"></div>
</template>