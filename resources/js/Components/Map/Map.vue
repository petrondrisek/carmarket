<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    city: { type: Object, default: { name: 'Pardubice', lat: 50.032, lng: 15.772} },
    radius: { type: Number, default: 5 },
})

// Constants
const KEY = import.meta.env.VITE_GOOGLE_MAP_API;
const CZECHIA = { north: 51.06, south: 48.55, west: 12.09, east: 18.87 };
let MAP;
let MARKER;
let CIRCLE;
let selectedCity = ref(props.city.name);
let selectedLat = ref(props.city.lat);
let selectedLng = ref(props.city.lng);
let isDARKMODEON = localStorage.getItem('theme') === 'dark';

// Google map
(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
key: KEY,
v: "weekly"
});

const createMap = async() => {
  const { Map } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
  const { ColorScheme } = await google.maps.importLibrary("core")

  MAP = new Map(document.getElementById("map"), {
        center: { lat: selectedLat.value, lng: selectedLng.value },
        zoom: 7,
        restriction: {
            latLngBounds: CZECHIA,
            strictBounds: false
        },
        mapId: import.meta.env.VITE_GOOGLE_MAP_ID,
        colorScheme: isDARKMODEON ? ColorScheme.DARK : ColorScheme.LIGHT,
        streetViewControl: false,
        fullscreenControl: false,
        mapTypeControl: false,
        clickableIcons: false
  });

  MARKER = new AdvancedMarkerElement({
    map: MAP,
    position: { lat: selectedLat.value, lng: selectedLng.value },
    gmpDraggable: true 
  });

  CIRCLE = new google.maps.Circle({
    strokeColor: "#FF0000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#FF0000",
    fillOpacity: 0.35,
    map: MAP,
    center: { lat: selectedLat.value, lng: selectedLng.value },
    radius: props.radius * 1000,
    clickable: false
  });

  // Map events
  const getMarkerPositionDetails = async (event) => {
    // Get click on city
    let geocoder = new google.maps.Geocoder();
    let city = null;
    
    // Get city
    await geocoder.geocode({ location: event.latLng }, (results, status) => {
      if(status === "OK" && results[0]) {
        const cityRes = results[0].address_components.find((component) => ["locality", "postal_town", "administrative_area_level_3"].some(type =>
          component.types.includes(type)
        ));

        city = cityRes?.long_name ?? null;
      }
      else city = null;
    });

    // Set selected lat and lng
    let lat = event.latLng.lat();
    let lng = event.latLng.lng();
    
    changeMapLocation(lat, lng, null, city);
  }

  google.maps.event.addListener(MARKER, "drag", (event) => {
    CIRCLE.setCenter(event.latLng);
  });

  google.maps.event.addListener(MARKER, "dragend", getMarkerPositionDetails);

  MAP.addListener("click", getMarkerPositionDetails);

}

const changeMapLocation = (lat, lng, radius = null, city = null) => {
    selectedLat.value = lat;
    selectedLng.value = lng;
    selectedCity.value = city ?? '';
    
    MARKER.position = new google.maps.LatLng(lat, lng);
    CIRCLE.setCenter({lat, lng});

    if(radius !== null) {
        CIRCLE.setRadius(radius * 1000);
    }
}

window.addEventListener("onThemeChange", (e) => {
    isDARKMODEON = e.detail === 'dark';
    google.maps.event.clearInstanceListeners(MAP);
    createMap();
});

// Lifecycle
onMounted(() => {
  createMap();
});

defineExpose({ changeMapLocation, selectedCity, selectedLat, selectedLng });
</script>

<template>
    <div id="map" class="w-full h-[320px]"></div>
</template>