<template>
  <transition name="fade-slide">
    <div v-if="open" class="fixed inset-0 z-40 flex">
      <!-- Overlay -->
      <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity duration-300" @click="$emit('close')"></div>
      <!-- Menu Panel -->
      <aside
        class="relative ml-auto w-80 max-w-full h-full bg-white/95 shadow-xl flex flex-col py-10 px-8 transition-transform duration-500 ease-in-out"
        @click.stop
        tabindex="0"
        aria-label="Main menu"
      >
        <!-- Close Button -->
        <button
          class="absolute top-4 right-4 p-2 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 text-secondary-500 hover:bg-secondary-100 transition"
          @click="$emit('close')"
          aria-label="Close menu"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <!-- Menu Links -->
        <nav class="flex flex-col gap-8 mt-8 text-center">
          <a
            v-for="item in menuItems"
            :key="item.name"
            :href="item.href"
            class="text-2xl font-serif uppercase tracking-widest text-secondary-900 hover:text-primary-600 transition-colors duration-200"
            @click="$emit('close')"
          >
            {{ item.name }}
          </a>
        </nav>
      </aside>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({
  open: {
    type: Boolean,
    default: false
  }
})

const menuItems = [
  { name: 'About', href: '/about' },
  { name: 'Portfolio', href: '/portfolio' },
  { name: 'Shop', href: '/shop' },
  { name: 'Contact', href: '/contact' },
]
</script>

<style scoped>
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: opacity 0.3s, transform 0.5s;
}
.fade-slide-enter-from, .fade-slide-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
.fade-slide-enter-to, .fade-slide-leave-from {
  opacity: 1;
  transform: translateX(0);
}
.font-serif {
  font-family: 'Playfair Display', 'Georgia', serif;
}
</style>
