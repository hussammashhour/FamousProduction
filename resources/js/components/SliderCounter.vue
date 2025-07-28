<template>
    <div class="slider-counter">
      <div
        v-for="(num, index) in slideNumbers"
        :key="index"
        class="counter-item"
      >
        <span class="number" :class="{ active: localSlide === index }">
          {{ num }}
        </span>

        <!-- Show gap when this is the current active slide (including last slide) -->
        <div
          v-if="localSlide === index"
          class="gap"
        >
          <div
            class="progress-bar"
            :style="{ width: progress + '%' }"
          ></div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';

  const props = defineProps({
    totalSlides: { type: Number, default: 5 },
    slideDuration: { type: Number, default: 5000 },
    autoplay: { type: Boolean, default: true },
    currentSlide: { type: Number, default: 0 },
  });
  const emit = defineEmits(['update:currentSlide']);

  const localSlide = ref(props.currentSlide);
  const progress = ref(0);
  const isPlaying = ref(props.autoplay);
  const currentStartTime = ref(Date.now());
  let interval = null;
  let animationFrame = null;

  // Generate slide numbers (01, 02, 03...)
  const slideNumbers = computed(() =>
    Array.from({ length: props.totalSlides }, (_, i) =>
      String(i + 1).padStart(2, '0')
    )
  );

  watch(() => props.currentSlide, (val) => {
    localSlide.value = val;
  });

  // Update progress bar continuously
  const updateProgress = () => {
    if (isPlaying.value) {
      const elapsed = Date.now() - currentStartTime.value;
      progress.value = Math.min(100, (elapsed / props.slideDuration) * 100);
    }
    animationFrame = requestAnimationFrame(updateProgress);
  };

  // Handle slide change
  const nextSlide = () => {
    const next = (localSlide.value + 1) % props.totalSlides;
    emit('update:currentSlide', next);
    localSlide.value = next;
    progress.value = 0;
    currentStartTime.value = Date.now();
  };

  // Start automatic slideshow
  const startProgress = () => {
    stopProgress();
    interval = setInterval(nextSlide, props.slideDuration);
  };

  // Stop slideshow
  const stopProgress = () => {
    if (interval) {
      clearInterval(interval);
      interval = null;
    }
  };

  // Pause functionality
  const pause = () => {
    isPlaying.value = false;
    stopProgress();
  };

  // Resume functionality
  const resume = () => {
    if (!props.autoplay) return;
    isPlaying.value = true;
    startProgress();
  };

  onMounted(() => {
    if (props.autoplay) {
      startProgress();
    }
    animationFrame = requestAnimationFrame(updateProgress);
  });

  onBeforeUnmount(() => {
    stopProgress();
    cancelAnimationFrame(animationFrame);
  });
  </script>

  <style scoped>
  .slider-counter {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: sans-serif;
    gap: 8px; /* Consistent padding between all numbers */
  }

  .counter-item {
    display: flex;
    align-items: center;
  }

  .number {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
    padding: 0 4px; /* Added padding around numbers */
  }

  .number.active {
    color: white;
    font-weight: bold;
    font-size: 18px;
  }

  .gap {
    position: relative;
    width: 40px;
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    margin-left: 4px; /* Reduced margin to maintain spacing */
  }

  .progress-bar {
    position: absolute;
    top: 0;
    left: 0;
    height: 2px;
    background: white;
    width: 0%;
    transition: width 0.1s linear;
  }
  </style>
