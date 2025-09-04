<template>
  <swiper
    :style="{
      '--swiper-navigation-color': '#fff',
      '--swiper-pagination-color': '#fff',
    }"
    :loop="true"
    :spaceBetween="10"
    :navigation="true"
    :thumbs="{ swiper: thumbsSwiper }"
    :modules="modules"
    class="mySwiper2"
  >
    <swiper-slide v-for="image in images">
      <img
        :src="image" alt="Swiper image" />
    </swiper-slide>
  </swiper>
  <swiper
    @swiper="setThumbsSwiper"
    :loop="true"
    :spaceBetween="10"
    :slidesPerView="4"
    :freeMode="true"
    :watchSlidesProgress="true"
    :modules="modules"
    class="mySwiper"
  >
    <swiper-slide v-for="(image, i) in images">
      <img
        :src="image" alt="Swiper image" @click="setThumbsSwiper(i)"/>
    </swiper-slide>
  </swiper>
</template>
<script setup>
    import { ref, toRefs } from 'vue';
    import { Swiper, SwiperSlide } from 'swiper/vue';

    import 'swiper/css';
    import 'swiper/css/free-mode';
    import 'swiper/css/navigation';
    import 'swiper/css/thumbs';
    import { FreeMode, Navigation, Thumbs } from 'swiper/modules';

    const props = defineProps({
        images: {
            type: Array,
            default: () => []
        }
    });
    const { images } = toRefs(props);
    
    const thumbsSwiper = ref(0);
    const modules = [FreeMode, Navigation, Thumbs]

    const setThumbsSwiper = (swiper) => {
        thumbsSwiper.value = swiper;    
    };
</script>
