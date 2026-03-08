import { ref } from "vue";

export function useGoogleMaps(initialLat: number = 50.032, initialLng: number = 15.772, initialCity: string = 'Pardubice') {
    let map: google.maps.Map | null = null;
    let marker: google.maps.marker.AdvancedMarkerElement | null = null;
    let circle: google.maps.Circle | null = null;
    let geocoder: google.maps.Geocoder | null = null;

    const lat = ref<number>(initialLat);
    const lng = ref<number>(initialLng);
    const city = ref<string>(initialCity);

    const initMap = async (htmlElement: HTMLElement, options: google.maps.MapOptions) => {
        const { Map } = await google.maps.importLibrary('maps') as google.maps.MapsLibrary;

        map = new Map(htmlElement, {
            center: { lat: lat.value, lng: lng.value },
            ...options
        });

        map.addListener('click', onMapClick);
    };

    const initMarker = async () => {
        if(!map) throw new Error('Map must be initialized before creating marker');

        const { AdvancedMarkerElement } = await google.maps.importLibrary('marker') as google.maps.MarkerLibrary;

        marker = new AdvancedMarkerElement({
            map,
            position: { lat: lat.value, lng: lng.value },
            gmpDraggable: true,
        });

        marker.addListener('drag', onMapDrag)
        marker.addListener('dragend', onMapDragEnd);
    };

    const initCircle = async (radius: number, color: string) => {
        if(!map || !marker) throw new Error('Map and marker must be initialized before creating circle');
        
        const { Circle } = await google.maps.importLibrary("maps") as google.maps.MapsLibrary;

        circle = new Circle({
            map,
            center: marker.position!,
            radius: radius,
            fillColor: color,
            fillOpacity: 0.3,
            strokeOpacity: 0.7,
            strokeColor: color
        });
    };
    
    const onMapClick = (e: google.maps.MapMouseEvent) => {
        if (e.latLng){
            updatePosition(e.latLng.lat(), e.latLng.lng());
            updateCityByLocation({ lat: e.latLng.lat(), lng: e.latLng.lng() });
        }
    }

    const onMapDrag = (e: any) => {
        if (e.latLng.lat() && e.latLng.lng()){
            updatePosition(e.latLng.lat(), e.latLng.lng());
        }
    }

    const onMapDragEnd = (e: any) => {
        if (e.latLng.lat() && e.latLng.lng()){
            updatePosition(e.latLng.lat(), e.latLng.lng());
            updateCityByLocation({ lat: e.latLng.lat(), lng: e.latLng.lng() });
        }
    }

    const updateMapTheme = (theme: 'LIGHT' | 'DARK') => {
        if(map) map.setOptions({ colorScheme: theme });
    }

    const updatePosition = async (newLat: number, newLng: number) => {
        lat.value = newLat;
        lng.value = newLng;
        
        if(marker) {
            marker.position = { lat: newLat, lng: newLng } as google.maps.LatLngLiteral;
        }

        if (marker && circle) {
            const pos = marker.position!;
            circle.setCenter(pos);
        }
    };

    const updateRadius = async (newRadius: number) => {
        if (circle) {
            circle.setRadius(newRadius * 1000);
        }
    };

    const updateCityByLocation = async (location: google.maps.LatLngLiteral) => {
        if (!geocoder) {
            const { Geocoder } = await google.maps.importLibrary("geocoding") as google.maps.GeocodingLibrary;
            geocoder = new Geocoder();
        }

        try {
            const { results } = await geocoder.geocode({ location });
            if (results && results[0]) {
                const locality = results[0].address_components.find(c => c.types.includes('locality'));
                const subLocality = results[0].address_components.find(c => c.types.includes('sublocality'));
                
                city.value = locality?.long_name || subLocality?.long_name || 'Neznámá lokalita';
            }
        } catch (e) {
            console.error("Geocoding failed:", e);
        }
    };

    const destroy = () => {
        if (marker){
            google.maps.event.clearInstanceListeners(marker);
            marker = null;
        }

        if (circle){
            google.maps.event.clearInstanceListeners(circle);
            circle = null;
        }

        if (map){
            google.maps.event.clearInstanceListeners(map);
            map = null;
        }

        if (geocoder){
            google.maps.event.clearInstanceListeners(geocoder);
            geocoder = null;
        }
    };

    return {
        lat,
        lng,
        city,
        updateMapTheme,
        updatePosition,
        updateRadius,
        updateCityByLocation,
        initMap,
        initMarker,
        initCircle,
        destroy
    }
}