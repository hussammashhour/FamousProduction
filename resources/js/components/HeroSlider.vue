<template>
  <section class="relative min-h-screen flex flex-col justify-between items-center overflow-hidden">
    <!-- Decorative Corners with margin -->
    <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-white/60 z-40"></div>
    <div class="absolute top-4 right-4 w-8 h-8 border-t-2 border-r-2 border-white/60 z-40"></div>
    <!-- Desktop Navbar -->
    <HeroNavbar class="z-30" />
    <!-- Background Images with Fade+Scale Transition -->
    <div class="absolute inset-0 w-full h-full">
      <transition name="hero-fade-scale" mode="out-in">
        <img
          v-if="images[currentSlide]"
          :key="images[currentSlide].url"
          :src="images[currentSlide].url"
          :alt="images[currentSlide].alt || 'Hero Image'"
          class="w-full h-full object-cover object-center absolute inset-0"
        />
      </transition>
      <div v-if="images[currentSlide]" class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Hamburger Menu Icon -->
    <button
      class="absolute top-6 right-6 z-20 p-2 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white/10 hover:bg-white/20 transition lg:hidden"
      @click="$emit('open-menu')"
      aria-label="Open menu"
    >
      <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
      </svg>
    </button>

    <!-- Centered Content -->
    <div class="relative z-10 flex flex-col items-center justify-center flex-1 px-4 text-center select-none">
      <h1 class="font-serif uppercase font-thin text-white text-4xl sm:text-5xl md:text-6xl lg:text-7xl tracking-widest leading-tight drop-shadow-lg">
        {{ images[currentSlide]?.title || 'Book Your Photo Tour!' }}
      </h1>
      <p v-if="images[currentSlide]?.subtitle" class="mt-6 max-w-xl mx-auto text-base sm:text-lg md:text-xl text-white/90 font-light drop-shadow">
        {{ images[currentSlide].subtitle }}
      </p>
    </div>
    <!-- Slider Counter in center bottom -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30">
      <SliderCounter :total-slides="images.length" :slide-duration="5000" :autoplay="true" v-model:currentSlide="currentSlide" />
    </div>
  </section>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import HeroNavbar from '@/components/HeroNavbar.vue'
import SliderCounter from '@/components/SliderCounter.vue'

const props = defineProps({
  images: {
    type: Array,
    required: true,
    // [{ url, alt, title, subtitle }]
  },
  interval: {
    type: Number,
    default: 6000 // ms
  }
})

const currentSlide = ref(0)

watch(() => props.images, () => {
  currentSlide.value = 0
})
</script>

<style scoped>
.font-serif {
  font-family: 'Playfair Display', 'Georgia', serif;
}
.hero-fade-scale-enter-active, .hero-fade-scale-leave-active {
  transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
}
.hero-fade-scale-enter-from, .hero-fade-scale-leave-to {
  opacity: 0;
  transform: scale(1.04);
}
.hero-fade-scale-leave-from, .hero-fade-scale-enter-to {
  opacity: 1;
  transform: scale(1);
}
</style>
