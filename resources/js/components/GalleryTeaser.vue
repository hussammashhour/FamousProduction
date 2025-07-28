<template>
  <section class="w-full py-16 bg-gradient-to-br from-[#DFEBF6] via-[#AAC7D8]/10 to-[#E6E6E6]">
    <div class="max-w-6xl mx-auto px-4">
      <div
        class="masonry"
        :style="{
          columnCount: columns,
          columnGap: '2rem',
        }"
      >
        <div
          v-for="(img, idx) in images"
          :key="img.url + idx"
          class="mb-8 break-inside-avoid relative group overflow-hidden rounded-2xl shadow-none"
        >
          <img
            :src="img.url"
            :alt="img.alt || 'Gallery Image'"
            class="w-full h-auto object-cover object-center transition-transform duration-700 ease-in-out group-hover:scale-105 group-hover:brightness-90 group-hover:shadow-xl"
            loading="lazy"
          />
          <div
            v-if="img.title"
            class="absolute bottom-4 left-4 bg-white/60 backdrop-blur-md px-4 py-2 rounded font-serif text-lg tracking-widest uppercase text-primary-900 opacity-0 group-hover:opacity-100 transition-opacity duration-500 shadow-md border border-primary-100"
          >
            {{ img.title }}
          </div>
          <div class="absolute inset-0 pointer-events-none group-hover:bg-[#DFEBF6]/40 group-hover:backdrop-blur-sm transition duration-500 rounded-2xl"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    required: true,
    // [{ url, alt, title }]
  }
})

const columns = ref(1)

function updateColumns() {
  if (window.innerWidth >= 1024) {
    columns.value = 3
  } else if (window.innerWidth >= 640) {
    columns.value = 2
  } else {
    columns.value = 1
  }
}

onMounted(() => {
  updateColumns()
  window.addEventListener('resize', updateColumns)
})
onBeforeUnmount(() => {
  window.removeEventListener('resize', updateColumns)
})
</script>

<style scoped>
.masonry {
  /* fallback for browsers without columns */
  display: block;
}
@media (min-width: 640px) {
  .masonry {
    column-count: 2;
  }
}
@media (min-width: 1024px) {
  .masonry {
    column-count: 3;
  }
}
.font-serif {
  font-family: 'Playfair Display', 'Georgia', serif;
}
</style>
