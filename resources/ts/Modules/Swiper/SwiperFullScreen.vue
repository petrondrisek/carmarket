<script setup lang="ts">
import { ref, watch, nextTick, onMounted, onUnmounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import type { Swiper as SwiperClass } from 'swiper';

import 'swiper/css';
import 'swiper/css/zoom';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import { Zoom, Navigation, Pagination } from 'swiper/modules';

const props = defineProps<{
  images: string[];
  show: boolean;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
}>();

const modules = [Zoom, Navigation, Pagination];
const swiperRef = ref<SwiperClass | null>(null);

const onSwiper = (swiper: SwiperClass) => {
  swiperRef.value = swiper;
};

watch(() => props.show, async (newValue) => {
  if (newValue) {
    await nextTick();

    if (swiperRef.value) {
      swiperRef.value.update();
    }
    
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});

const handleKeyDown = (e: KeyboardEvent) => {
  if (e.key === 'Escape' && props.show) {
    emit('close');
  }
};

onMounted(() => window.addEventListener('keydown', handleKeyDown));

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown);
  document.body.style.overflow = '';
});
</script>

<template>
  <div 
    v-show="show" 
    class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center"
  >
    <button 
      class="fixed z-[110] top-6 right-6 text-white/70 hover:text-white text-5xl transition-colors outline-none focus:text-white"
      @click="emit('close')"
      aria-label="Zavřít galerii"
    >
      &times;
    </button>

    <Swiper
      @swiper="onSwiper"
      :modules="modules"
      :zoom="true"
      :navigation="true"
      :loop="images.length > 1"
      :pagination="{ clickable: true }"
      :style="{
        '--swiper-navigation-color': '#fff',
        '--swiper-pagination-color': '#fff',
      }"
      class="w-full h-full"
    >
      <SwiperSlide v-for="(image, index) in images" :key="index">
        <div class="swiper-zoom-container">
          <img 
            :src="image" 
            alt="Fullscreen image" 
            class="max-h-screen object-contain"
          />
        </div>
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<style scoped>
.swiper-zoom-container {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

:deep(.swiper-pagination-bullet) {
  background: #fff;
}

@media (max-width: 640px) {
  :deep(.swiper-button-next),
  :deep(.swiper-button-prev) {
    display: none;
  }
}
</style>