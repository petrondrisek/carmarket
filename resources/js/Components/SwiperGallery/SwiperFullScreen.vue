<template>
  <Swiper
    v-show="show"
    :style="{
      '--swiper-navigation-color': '#fff',
      '--swiper-pagination-color': '#fff',
    }"
    :zoom="true"
    :navigation="true"
    :loop="true"
    :pagination="{
      clickable: true,
    }"
    :modules="modules"
    class="mySwiper3"
  >
    <button class="swiper-close-button fixed z-50 top-8 right-8 text-white hover:text-gray-400 transition duration-150 ease-in-out text-5xl cursor-pointer" @click="$emit('close')">
        &times;
    </button>
    <swiper-slide v-for="image in images">
      <div class="swiper-zoom-container">
        <img :src="image" alt="Swiper image" />
      </div> 
    </swiper-slide>
  </swiper>
</template>
<script setup>
  import { ref, toRefs } from 'vue';
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import 'swiper/css';
  import 'swiper/css/zoom';
  import 'swiper/css/navigation';
  import 'swiper/css/pagination';

  // import required modules
  import { Zoom, Navigation, Pagination } from 'swiper/modules';

  const swiper = ref(null);
  const props = defineProps({
    images: Array,
    show: Boolean
  });
  const { images, show } = toRefs(props);

  const modules = [Zoom, Navigation, Pagination];
</script>
