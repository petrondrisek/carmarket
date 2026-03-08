<script setup lang="ts">
import { onMounted, onUnmounted, useTemplateRef, watch } from 'vue';
import { useGoogleMaps } from './useGoogleMaps';

interface Props {
    radius?: number;
    initialLat?: number;
    initialLng?: number;
    initialCity?: string;
}

const props = withDefaults(defineProps<Props>(), {
    radius: 10,
    initialLat: 50.032,
    initialLng: 15.772,
    initialCity: 'Pardubice',
});

const emit = defineEmits<{
    (e: 'updated-location', city: string): void;
}>();

const mapRef = useTemplateRef('mapRef');
const { 
    lat, lng, city, updatePosition, updateRadius,
    initMap, initMarker, initCircle, destroy 
} = useGoogleMaps(props.initialLat, props.initialLng, props.initialCity);

onMounted(async () => {
    try {
        await initMap(mapRef.value as HTMLDivElement, {
            center: { lat: lat.value, lng: lng.value },
            zoom: 7,
            mapId: "6e6e8cdb4240be66513b73ab",
        });

        await initMarker();

        await initCircle(props.radius * 1000, '#FF0000');

        emit('updated-location', city.value);
    } catch (error) {
        console.error('Error initializing Google Map:', error);
    }
});

watch([city], () => {
    emit('updated-location', city.value);
});

onUnmounted(() => {
    destroy();
});

defineExpose({
    updateRadius,
    updatePosition,
    lat,
    lng,
    city
});
</script>

<template>
    <div ref="mapRef" class="w-full h-[320px]"></div>
</template>