<template>
  <nav :class="['w-full z-30 items-center justify-center px-8 pt-6 select-none', 'hidden lg:flex', isHome ? '' : 'bg-white']" style="pointer-events: none;">
    <div class="relative w-full max-w-6xl mx-auto flex items-center justify-between h-20" style="pointer-events: auto;">
      <!-- Left Menu -->
      <div class="flex-1 flex items-center justify-start gap-8 h-full">
        <Link
          v-for="item in leftMenu.filter(item => item.name !== 'Portfolio')"
          :key="item.name"
          :href="item.href"
          :class="[
            'text-sm font-semibold tracking-widest uppercase transition-colors duration-200 pb-2',
            isHome ? 'text-white hover:text-primary-200' : 'text-black hover:text-primary-600',
            isActive(item.href) ? 'border-b-2 border-primary-600' : 'border-b-2 border-transparent'
          ]"
        >
          {{ item.name }}
        </Link>

        <!-- Portfolio Dropdown -->
        <div class="relative group">
          <button
            :class="[
              'text-sm font-semibold tracking-widest uppercase transition-colors duration-200 pb-2 flex items-center gap-1',
              isHome ? 'text-white hover:text-primary-200' : 'text-black hover:text-primary-600',
              isActive('/portfolio') ? 'border-b-2 border-primary-600' : 'border-b-2 border-transparent'
            ]"
            @mouseenter="showPortfolioDropdown = true"
            @mouseleave="showPortfolioDropdown = false"
          >
            Portfolio
            <svg class="w-3 h-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div
            v-show="showPortfolioDropdown"
            @mouseenter="showPortfolioDropdown = true"
            @mouseleave="showPortfolioDropdown = false"
            class="absolute top-full left-0 mt-3 w-72 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 py-3 z-50 transform transition-all duration-300 ease-out"
            style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);"
          >
            <!-- Dropdown Arrow -->
            <div class="absolute -top-2 left-6 w-4 h-4 bg-white/95 backdrop-blur-md border-l border-t border-white/20 transform rotate-45"></div>

            <!-- All Categories Link -->
            <Link
              href="/portfolio"
              class="block px-6 py-3 text-sm text-slate-700 hover:bg-slate-50/80 transition-all duration-200 rounded-lg mx-2 group/item"
              @click="showPortfolioDropdown = false"
            >
              <div class="flex items-center justify-between">
                <span class="font-medium">All Categories</span>
                <span class="text-xs text-slate-400 group-hover/item:text-slate-600 transition-colors">View all</span>
              </div>
            </Link>

            <!-- Divider -->
            <div class="border-t border-slate-100 my-2 mx-4"></div>

            <!-- Loading State -->
            <div v-if="loadingTags" class="px-6 py-3">
              <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-4 w-4 border-2 border-slate-200 border-t-primary-600"></div>
                <span class="ml-3 text-sm text-slate-500">Loading categories...</span>
              </div>
            </div>

            <!-- Category Links -->
            <div v-else class="max-h-64 overflow-y-auto custom-scrollbar">
              <Link
                v-for="tag in tags"
                :key="tag.id"
                :href="`/portfolio?tag=${tag.id}`"
                class="block px-6 py-3 text-sm text-slate-700 hover:bg-slate-50/80 transition-all duration-200 rounded-lg mx-2 group/item"
                @click="showPortfolioDropdown = false"
              >
                <div class="flex items-center justify-between">
                  <span class="font-medium">{{ tag.name }}</span>
                  <span class="text-xs text-slate-400 group-hover/item:text-slate-600 transition-colors bg-slate-100 px-2 py-1 rounded-full">
                    {{ tag.total_photos_count || tag.photos_count }}
                  </span>
                </div>
              </Link>
            </div>

            <!-- Empty State -->
            <div v-if="tags.length === 0 && !loadingTags" class="px-6 py-4 text-center">
              <div class="text-slate-400 text-sm">
                <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p>No categories available</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Center Logo Only -->
      <div class="flex flex-col items-center justify-center h-full px-8">
        <Link href="/">
          <img
            src="/images/famous_logoW.png"
            alt="Famous Production"
            class="h-16 w-auto mb-5"
            :style="isHome ? '' : 'filter: invert(1);'"
          />
        </Link>
      </div>
      <!-- Right Menu + Instagram -->
      <div class="flex-1 flex items-center justify-end gap-8 h-full">
        <Link
          v-for="item in rightMenu"
          :key="item.name"
          :href="item.href"
          :class="[
            'text-sm font-semibold tracking-widest uppercase transition-colors duration-200 pb-2',
            isHome ? 'text-white hover:text-primary-200' : 'text-black hover:text-primary-600',
            isActive(item.href) ? 'border-b-2 border-primary-600' : 'border-b-2 border-transparent'
          ]"
        >
          {{ item.name }}
        </Link>
        <!-- Instagram Icon -->
        <a href="https://www.instagram.com/famous.production.lb" target="_blank" class="relative ml-4 group">
          <svg
            class="w-6 h-6 transition-colors duration-200"
            :class="isHome ? 'text-white group-hover:text-primary-200' : 'text-black group-hover:text-primary-600'"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
        </a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import axios from 'axios';

const leftMenu = [
  { name: 'About', href: '/about' },
  { name: 'Portfolio', href: '/portfolio' },
  { name: 'Services', href: '/services' },
];
const rightMenu = [
  { name: 'Gallery', href: '/gallery' },
  { name: 'Contact', href: '/contact' },
  { name: 'Book Now', href: '/booking' },
];

const page = usePage();
const isHome = computed(() => page.url === '/');
const isActive = (href) => page.url === href;

// Portfolio dropdown state
const showPortfolioDropdown = ref(false);
const tags = ref([]);
const loadingTags = ref(false);

// Load tags for portfolio dropdown
const loadTags = async () => {
  loadingTags.value = true;
  try {
    const response = await axios.get('/api/tags');
    tags.value = response.data.data;
  } catch (error) {
    console.error('Error loading tags:', error);
    tags.value = [];
  } finally {
    loadingTags.value = false;
  }
};

onMounted(() => {
  loadTags();
});
</script>

<style scoped>
.font-heading {
  font-family: 'Playfair Display', 'Georgia', serif;
}

/* Custom Scrollbar for Dropdown */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(148, 163, 184, 0.3);
  border-radius: 2px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(148, 163, 184, 0.5);
}

/* Enhanced hover effects */
.group\/item:hover {
  transform: translateX(2px);
}

/* Backdrop blur fallback */
@supports not (backdrop-filter: blur(12px)) {
  .backdrop-blur-md {
    background: rgba(255, 255, 255, 0.98);
  }
}
</style>
