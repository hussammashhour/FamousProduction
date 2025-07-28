<template>
  <section class="relative min-h-screen flex flex-col justify-between items-center overflow-hidden">
    <!-- Background Image & Overlay -->
    <div class="absolute inset-0 w-full h-full">
      <img
        src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80"
        alt="Photo Tour Hero"
        class="w-full h-full object-cover object-center"
      />
      <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <!-- Top Navigation (slot for Navbar) -->
    <div class="relative w-full z-10">
      <slot name="navbar" />
    </div>

    <!-- Centered Content -->
    <div class="relative z-10 flex flex-col items-center justify-center flex-1 px-4 text-center">
      <h1 class="font-serif uppercase font-extrabold text-white text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-tight tracking-tight drop-shadow-lg">
        Book Your<br />Photo Tour!
      </h1>
      <p class="mt-6 max-w-xl mx-auto text-base sm:text-lg md:text-xl text-white/90 font-medium drop-shadow">
        Photo tour for creative souls. Germany, 20 - 25 October 2025. Intensive photo tour includes creating photos for your portfolio in 3 different locations and one special day of shooting owls at a sunset scenery.
      </p>
      <button class="mt-8 btn btn-outline text-white border-white hover:bg-white/10 hover:text-white transition-all duration-200 px-8 py-3 text-lg font-semibold tracking-widest uppercase flex items-center gap-2">
        Book Now
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
        </svg>
      </button>
    </div>

    <!-- Pagination Dots -->
    <div class="relative z-10 flex justify-center items-center mb-8">
      <div class="flex space-x-4 text-white/80 text-lg tracking-widest">
        <span class="opacity-70">01</span>
        <span>02</span>
        <span class="mx-2">—</span>
        <span class="opacity-70">03</span>
        <span>04</span>
        <span>05</span>
        <span>06</span>
      </div>
    </div>

    <!-- Decorative Corners -->
    <div class="absolute left-0 top-0 w-8 h-8 border-t-2 border-l-2 border-white/60"></div>
    <div class="absolute right-0 top-0 w-8 h-8 border-t-2 border-r-2 border-white/60"></div>
    <div class="absolute left-0 bottom-0 w-8 h-8 border-b-2 border-l-2 border-white/60"></div>
    <div class="absolute right-0 bottom-0 w-8 h-8 border-b-2 border-r-2 border-white/60"></div>
  </section>
</template>

<script setup>
// No script needed for static hero
</script>

<style scoped>
.font-serif {
  font-family: 'Playfair Display', 'Georgia', serif;
}
</style>
