<script setup lang="ts">
  import '@/../css/particles.css';
</script>

<template>
  <div class="particle-container">
      <div class="content">
          <slot></slot>
      </div>
      
      <div class="circle-container" v-for="i in 100">
        <div :key="'particle-' + i" class="circle"></div>
      </div>
  </div>
</template>