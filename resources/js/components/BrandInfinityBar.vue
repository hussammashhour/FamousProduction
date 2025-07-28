<template>
  <div class="brand-infinity-bar">
    <div class="brand-track" :style="trackStyle">
      <div v-for="(brand, i) in repeatedBrands" :key="i" class="brand-item">
        <img :src="brand.url" :alt="brand.alt" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  brands: {
    type: Array,
    required: true, // [{ url, alt }]
  },
  speed: {
    type: Number,
    default: 40, // px per second
  },
});

// Repeat the brands to ensure seamless looping
const repeatedBrands = computed(() => [...props.brands, ...props.brands]);

const trackStyle = computed(() => ({
  animationDuration: `${(props.brands.length * 160) / props.speed}s`,
}));
</script>

<style scoped>
.brand-infinity-bar {
  width: 100%;
  overflow: hidden;
  background: #f8f6f2;
  padding: 1.5rem 0;
  border-radius: 0;
  border-top: 1px solid #ece8e0;
  border-bottom: 1px solid #ece8e0;
  position: relative;
}
.brand-track {
  display: flex;
  width: max-content;
  animation: scroll-left linear infinite;
  align-items: center;
  position: relative;
}
.brand-item {
  flex: 0 0 auto;
  margin: 0 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 120px;
  min-height: 40px;
  opacity: 0.85;
  transition: opacity 0.2s;
}
.brand-item img {
  max-height: 48px;
  max-width: 140px;
  object-fit: contain;
  filter: grayscale(0.2) contrast(1.1);
  transition: filter 0.2s, opacity 0.2s;
}
.brand-item:hover img {
  filter: grayscale(0) contrast(1.2);
  opacity: 1;
}
@keyframes scroll-left {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* Ensure no horizontal overflow on the page */
:global(body) {
  overflow-x: hidden;
}
</style>
