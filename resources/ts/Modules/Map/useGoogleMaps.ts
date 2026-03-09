type Position = { lat: number, lng: number };

export function useGoogleMaps(
    onUpdatePosition: (lat: number, lng: number) => void,
    onUpdateCity: (city: string) => void
) {
    let map: google.maps.Map | null = null;
    let marker: google.maps.marker.AdvancedMarkerElement | null = null;
    let circle: google.maps.Circle | null = null;
    let geocoder: google.maps.Geocoder | null = null;

    const initMap = async (htmlElement: HTMLElement, options: google.maps.MapOptions, position: Position) => {
        const { Map } = await google.maps.importLibrary('maps') as google.maps.MapsLibrary;

        map = new Map(htmlElement, {
            center: { lat: position.lat, lng: position.lng },
            ...options
        });

        map.addListener('click', onMapClick);
    };

    const initMarker = async (position: Position) => {
        if(!map) throw new Error('Map must be initialized before creating marker');

        const { AdvancedMarkerElement } = await google.maps.importLibrary('marker') as google.maps.MarkerLibrary;

        marker = new AdvancedMarkerElement({
            map,
            position: { lat: position.lat, lng: position.lng },
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

    const updateMapTheme = (theme: 'LIGHT' | 'DARK') => {
        // Future use, now it's not possible due to limitations of API.
        // To work properly, the map needs to be reinitialized
        if (map) {
            map.setOptions({ 
                colorScheme: theme
            });
        }
    }

    const updateRadius = async (newRadius: number) => {
        if (circle) {
            circle.setRadius(newRadius * 1000);
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

    const updatePositionWithoutEffect = async (newLat: number, newLng: number) => {
        if(marker) {
            marker.position = { lat: newLat, lng: newLng } as google.maps.LatLngLiteral;
        }
        
        if (marker && circle) {
            const pos = marker.position!;
            circle.setCenter(pos);
        }
    }

    // private
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

    const updatePosition = async (newLat: number, newLng: number) => {
        if(marker) {
            marker.position = { lat: newLat, lng: newLng } as google.maps.LatLngLiteral;
        }
        
        if (marker && circle) {
            const pos = marker.position!;
            circle.setCenter(pos);
        }
        
        onUpdatePosition(newLat, newLng);
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
                
                onUpdateCity(locality?.long_name || subLocality?.long_name || 'Neznámá lokalita');
            }
        } catch (e) {
            console.error("Geocoding failed:", e);
        }
    };

    return {
        updatePositionWithoutEffect,
        updateMapTheme,
        updateRadius,
        initMap,
        initMarker,
        initCircle,
        destroy
    }
}