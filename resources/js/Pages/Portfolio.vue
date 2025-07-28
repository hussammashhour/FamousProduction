<template>
  <MainLayout>
    <div class="portfolio-page">
      <!-- Header -->
      <div class="portfolio-header">
        <div class="container mx-auto px-4 py-16 text-center">
          <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 mb-4">
            {{ selectedTag ? `Portfolio - ${selectedTag.name}` : 'Portfolio' }}
          </h1>
          <p class="text-lg text-secondary-700 max-w-2xl mx-auto">
            {{ selectedTag ? `Explore our ${selectedTag.name.toLowerCase()} photography collection` : 'Discover our diverse photography portfolio organized by categories' }}
          </p>

          <!-- Tag Filter -->
          <div class="mt-8">
            <div class="flex flex-wrap justify-center gap-3">
              <button
                @click="selectTag(null)"
                :class="[
                  'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
                  !selectedTag
                    ? 'bg-primary-600 text-white shadow-lg'
                    : 'bg-secondary-100 text-secondary-700 hover:bg-secondary-200'
                ]"
              >
                All Categories
              </button>
              <button
                v-for="tag in tags"
                :key="tag.id"
                @click="selectTag(tag)"
                :class="[
                  'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
                  selectedTag?.id === tag.id
                    ? 'bg-primary-600 text-white shadow-lg'
                    : 'bg-secondary-100 text-secondary-700 hover:bg-secondary-200'
                ]"
              >
                {{ tag.name }}
                <span class="ml-1 text-xs opacity-75">({{ tag.total_photos_count }})</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="container mx-auto px-4 py-16">
        <div class="flex justify-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
        </div>
      </div>

      <!-- Photos Grid -->
      <div v-else-if="photos.length > 0" class="container mx-auto px-4 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div
            v-for="photo in photos"
            :key="photo.id"
            class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer"
            @click="openPhotoModal(photo)"
          >
            <img
              :src="photo.url"
              :alt="photo.caption || 'Portfolio photo'"
              class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
            />

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-end">
              <div class="p-4 w-full transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <h3 class="text-white font-semibold text-lg mb-1">
                  {{ photo.post.title || 'Untitled' }}
                </h3>
                <p class="text-white text-sm opacity-90">
                  {{ photo.caption || 'No description' }}
                </p>
                <div class="flex items-center justify-between mt-2 text-white text-xs">
                  <div class="flex items-center space-x-2">
                    <span>❤️ {{ photo.post.likes_count }}</span>
                    <span>💬 {{ photo.post.comments_count }}</span>
                  </div>
                  <div v-if="photo.tags && photo.tags.length > 0" class="flex flex-wrap gap-1">
                    <span
                      v-for="tag in photo.tags.slice(0, 2)"
                      :key="tag.id"
                      class="px-1 py-0.5 bg-white bg-opacity-20 rounded text-xs"
                    >
                      {{ tag.name }}
                    </span>
                    <span v-if="photo.tags.length > 2" class="px-1 py-0.5 bg-white bg-opacity-20 rounded text-xs">
                      +{{ photo.tags.length - 2 }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-md mx-auto">
          <div class="text-6xl mb-4">📸</div>
          <h3 class="text-xl font-semibold text-secondary-900 mb-2">
            {{ selectedTag ? `No ${selectedTag.name.toLowerCase()} photos yet` : 'No photos available' }}
          </h3>
          <p class="text-secondary-600">
            {{ selectedTag ? `We're working on adding more ${selectedTag.name.toLowerCase()} content.` : 'Check back soon for our latest portfolio updates.' }}
          </p>
        </div>
      </div>

      <!-- Photo Modal -->
      <div v-if="selectedPhoto" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-90" @click="closePhotoModal">
        <div class="relative max-w-4xl max-h-full" @click.stop>
          <button
            @click="closePhotoModal"
            class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>

          <div class="bg-white rounded-lg overflow-hidden">
            <img
              :src="selectedPhoto.url"
              :alt="selectedPhoto.caption || 'Portfolio photo'"
              class="w-full max-h-96 object-cover"
            />
            <div class="p-6">
              <h3 class="text-xl font-semibold text-secondary-900 mb-2">
                {{ selectedPhoto.post.title || 'Untitled' }}
              </h3>
              <p class="text-secondary-600 mb-4">
                {{ selectedPhoto.caption || 'No description available' }}
              </p>
              <div class="flex items-center justify-between text-sm text-secondary-500 mb-3">
                <span>By {{ selectedPhoto.post.user?.first_name }} {{ selectedPhoto.post.user?.last_name }}</span>
                <div class="flex items-center space-x-4">
                  <span>❤️ {{ selectedPhoto.post.likes_count }}</span>
                  <span>💬 {{ selectedPhoto.post.comments_count }}</span>
                </div>
              </div>

              <!-- Tags -->
              <div v-if="selectedPhoto.tags && selectedPhoto.tags.length > 0" class="flex flex-wrap gap-2">
                <span
                  v-for="tag in selectedPhoto.tags"
                  :key="tag.id"
                  class="px-2 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-medium"
                >
                  {{ tag.name }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import { ref, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const tags = ref([]);
const photos = ref([]);
const selectedTag = ref(null);
const selectedPhoto = ref(null);
const loading = ref(false);

// Load tags on component mount
onMounted(async () => {
  await loadTags();

  // Check if there's a tag parameter in the URL
  const urlParams = new URLSearchParams(window.location.search);
  const tagId = urlParams.get('tag');
  if (tagId) {
    const tag = tags.value.find(t => t.id == tagId);
    if (tag) {
      await selectTag(tag);
      return;
    }
  }
  // If no tag is selected, load all photos
  await selectTag(null);
});

const loadTags = async () => {
  try {
    const response = await axios.get('/api/tags');
    tags.value = response.data.data;
  } catch (error) {
    console.error('Error loading tags:', error);
  }
};

const selectTag = async (tag) => {
  selectedTag.value = tag;
  loading.value = true;

  try {
    if (tag) {
      // Load photos for specific tag
      const response = await axios.get(`/api/tags/${tag.id}/photos`);
      photos.value = response.data.data.photos;
    } else {
      // Load all photos
      const response = await axios.get('/api/portfolio/photos');
      photos.value = response.data.data.photos;
    }
  } catch (error) {
    console.error('Error loading photos:', error);
    photos.value = [];
  } finally {
    loading.value = false;
  }
};

const openPhotoModal = (photo) => {
  selectedPhoto.value = photo;
};

const closePhotoModal = () => {
  selectedPhoto.value = null;
};
</script>

<style scoped>
.font-heading {
  font-family: 'Playfair Display', 'Georgia', serif;
}

.portfolio-header {
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
  border-bottom: 1px solid #e2e8f0;
}
</style>
