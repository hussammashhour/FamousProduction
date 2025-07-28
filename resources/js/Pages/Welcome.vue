<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import HeroSlider from '@/components/HeroSlider.vue';
import OffCanvasMenu from '@/components/OffCanvasMenu.vue';
import FooterSection from '@/components/FooterSection.vue';
import HomeLoadingSpinner from '@/components/UI/HomeLoadingSpinner.vue';
import { useInfiniteScroll } from '../composables/useInfiniteScroll';
import SliderCounter from '@/components/SliderCounter.vue';
import BrandInfinityBar from '@/components/BrandInfinityBar.vue';

// --- DATA REFS ---
const menuOpen = ref(false);
const featuredPosts = ref([]);
const announcements = ref([]);
const team = ref([]);
const reviews = ref([]);
const tags = ref([]);
const nextBooking = ref(null);
const instagramPosts = ref([]); // TODO: Replace with real data when backend ready
const awards = ref([]); // TODO: Replace with real data when backend ready

// --- CONTACT FORM REFS ---
const contactForm = ref({ name: '', email: '', message: '' });
const contactSuccess = ref(false);
const contactError = ref(false);

// Initialize infinite scroll for latest posts
const {
  items: latestPosts,
  loading: postsLoading,
  hasMore: hasMorePosts,
  error: postsError,
  reset: resetPosts
} = useInfiniteScroll({
  url: '/api/home/posts',
  perPage: 6,
  threshold: 300,
  onError: (err) => {
    console.error('Error loading posts:', err);
  }
});

// --- FETCH FUNCTIONS ---
async function fetchFeaturedPosts() {
  const { data } = await axios.get('/api/home/featured-posts');
  featuredPosts.value = data.data || data;
}
async function fetchAnnouncements() {
  const { data } = await axios.get('/api/announcements?limit=3');
  announcements.value = data.data || data;
}
async function fetchTeam() {
  const { data } = await axios.get('/api/users?role=team');
  team.value = data.data || data;
}
async function fetchReviews() {
  const { data } = await axios.get('/api/reviews?limit=6');
  reviews.value = data.data || data;
}
async function fetchTags() {
  const { data } = await axios.get('/api/tags?with_count=1');
  tags.value = data.data || data;
}
async function fetchNextBooking() {
  const { data } = await axios.get('/api/bookings/next-available');
  nextBooking.value = data.data || data;
}
// TODO: fetchInstagramPosts, fetchAwards when backend ready

async function submitContact() {
  contactSuccess.value = false;
  contactError.value = false;
  try {
    await axios.post('/contact', contactForm.value);
    contactSuccess.value = true;
    contactForm.value = { name: '', email: '', message: '' };
  } catch (e) {
    contactError.value = true;
  }
}

onMounted(() => {
  fetchFeaturedPosts();
  fetchAnnouncements();
  fetchTeam();
  fetchReviews();
  fetchTags();
  fetchNextBooking();
});

const heroImages = [
  {
    url: '/images/pic1.jpg',
    alt: 'Hero Image 1',
    title: 'Unleash Creativity',
    subtitle: 'Every moment is a masterpiece.',
  },
  {
    url: '/images/pic2.jpg',
    alt: 'Hero Image 2',
    title: 'Capture the Adventure',
    subtitle: 'Photography that tells your story.',
  },
  {
    url: '/images/pic3.jpg',
    alt: 'Hero Image 3',
    title: 'Memories in Focus',
    subtitle: 'Preserve your best memories with us.',
  },
];

const brands = [
  { url: '/images/brands/sony_logo.png', alt: 'Sony' },
  { url: '/images/brands/leica_logo.png', alt: 'Leica' },
  { url: '/images/brands/samsung_logo.png', alt: 'Samsung' },
  { url: '/images/brands/nikon_logo.png', alt: 'Nikon' },
  { url: '/images/brands/canon_logo.png', alt: 'Canon' },
  { url: '/images/brands/adobe_logo.png', alt: 'Adobe' },
  { url: '/images/brands/panasonic_logo.png', alt: 'Panasonic' },
];
</script>

<template>
  <!-- HERO SECTION -->
  <HeroSlider :images="heroImages" @open-menu="menuOpen = true" />
  <BrandInfinityBar :brands="brands" />
  <OffCanvasMenu :open="menuOpen" @close="menuOpen = false" />

  <!-- FEATURED PROJECTS SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#DFEBF6] via-[#AAC7D8]/60 to-[#E6E6E6]">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Featured Projects</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="post in featuredPosts" :key="post.id" class="rounded-3xl bg-white/60 backdrop-blur-lg shadow-xl p-6 flex flex-col items-center transition hover:scale-105">
          <img :src="post.cover_url || post.photos?.[0]?.url" :alt="post.title" class="w-full h-48 object-cover rounded-2xl mb-4" />
          <h3 class="text-xl font-bold text-secondary-900 mb-2">{{ post.title }}</h3>
          <p class="text-secondary-700 text-base mb-4">{{ post.excerpt || post.description }}</p>
          <a :href="`/portfolio/${post.id}`" class="px-6 py-2 rounded bg-primary-700 text-white font-semibold uppercase tracking-widest shadow hover:bg-primary-800 transition">View Project</a>
        </div>
      </div>
    </div>
  </section>

  <!-- LATEST PORTFOLIO SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#E6E6E6] via-[#DFEBF6]/60 to-[#AAC7D8]/20">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Latest Portfolio</h2>

      <!-- Posts Grid -->
      <div v-if="latestPosts.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="post in latestPosts" :key="post.id" class="rounded-3xl bg-white/60 backdrop-blur-lg shadow-xl p-6 flex flex-col items-center transition hover:scale-105">
          <img :src="post.cover_url || post.photos?.[0]?.url" :alt="post.title" class="w-full h-48 object-cover rounded-2xl mb-4" />
          <h3 class="text-xl font-bold text-secondary-900 mb-2">{{ post.title }}</h3>
          <p class="text-secondary-700 text-base mb-4">{{ post.excerpt || post.description }}</p>
          <a :href="`/portfolio/${post.id}`" class="px-6 py-2 rounded bg-primary-700 text-white font-semibold uppercase tracking-widest shadow hover:bg-primary-800 transition">View Project</a>
        </div>
      </div>

      <!-- Loading States -->
      <div v-if="postsLoading && latestPosts.length === 0" class="text-center py-16">
        <HomeLoadingSpinner />
      </div>

      <!-- Error State -->
      <div v-if="postsError && latestPosts.length === 0" class="error-state text-center py-16 text-secondary-500">
        <div class="text-5xl mb-2">⚠️</div>
        <div class="text-lg">Error loading posts</div>
        <p class="text-sm mt-1">{{ postsError }}</p>
        <button @click="resetPosts" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
          Try Again
        </button>
      </div>

      <!-- Load More Loading -->
      <div v-if="postsLoading && latestPosts.length > 0" class="text-center py-8">
        <HomeLoadingSpinner />
      </div>

      <!-- No More Posts -->
      <div v-if="!hasMorePosts && latestPosts.length > 0" class="text-center py-8 text-secondary-400">
        <p class="text-sm">No more posts to load</p>
      </div>
    </div>
  </section>

  <!-- CLIENT STORIES SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#DFEBF6] via-[#AAC7D8]/30 to-[#E6E6E6]">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Client Stories</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div v-for="post in featuredPosts" :key="post.id" class="rounded-3xl bg-white/70 backdrop-blur-lg shadow-lg p-8 flex flex-col items-center">
          <img :src="post.cover_url || post.photos?.[0]?.url" :alt="post.title" class="w-20 h-20 object-cover rounded-full mb-4" />
          <blockquote class="italic text-secondary-800 text-lg mb-4">{{ post.excerpt || post.description }}</blockquote>
          <div class="text-primary-700 font-bold uppercase tracking-widest">{{ post.title }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ANNOUNCEMENTS SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#E6E6E6] via-[#DFEBF6]/60 to-[#AAC7D8]/20">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">What's New</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div v-for="a in announcements" :key="a.id" class="rounded-3xl bg-white/70 backdrop-blur-lg shadow-lg p-8 flex flex-col items-center">
          <div class="text-primary-700 font-bold uppercase tracking-widest mb-2">{{ a.title }}</div>
          <div class="text-secondary-800 text-base mb-2">{{ a.summary || a.body }}</div>
          <div class="text-xs text-primary-400">{{ a.created_at }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- OUR TEAM SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#AAC7D8]/10 via-[#DFEBF6]/40 to-[#E6E6E6]">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Our Team</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="member in team" :key="member.id" class="rounded-3xl bg-white/60 backdrop-blur-lg shadow-xl p-6 flex flex-col items-center transition hover:scale-105">
          <img :src="member.avatar_url || 'https://via.placeholder.com/100'" :alt="member.name" class="w-24 h-24 object-cover rounded-full mb-4" />
          <h3 class="text-xl font-bold text-secondary-900 mb-2">{{ member.name }}</h3>
          <p class="text-secondary-700 text-base mb-2">{{ member.role || member.title }}</p>
          <p class="text-secondary-500 text-sm">{{ member.bio }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HAPPY CLIENTS (TESTIMONIALS) SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#DFEBF6] via-[#AAC7D8]/30 to-[#E6E6E6]">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Happy Clients</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div v-for="review in reviews" :key="review.id" class="rounded-3xl bg-white/70 backdrop-blur-lg shadow-lg p-8 flex flex-col items-center">
          <img :src="review.user?.avatar_url || 'https://via.placeholder.com/80'" :alt="review.user?.name" class="w-16 h-16 object-cover rounded-full mb-4" />
          <blockquote class="italic text-secondary-800 text-lg mb-4">"{{ review.body }}"</blockquote>
          <div class="text-primary-700 font-bold uppercase tracking-widest">{{ review.user?.name }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- POPULAR TAGS SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#E6E6E6] via-[#DFEBF6]/60 to-[#AAC7D8]/20">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary-900 mb-8 tracking-widest uppercase drop-shadow-lg">Popular Tags</h2>
      <div class="flex flex-wrap justify-center gap-4">
        <a v-for="tag in tags" :key="tag.id" :href="`/portfolio?tag=${tag.id}`" class="px-6 py-2 rounded-full bg-primary-100 text-primary-700 font-semibold uppercase tracking-widest shadow hover:bg-primary-200 transition">
          {{ tag.name }} <span class="ml-2 text-xs text-primary-400">({{ tag.posts_count || tag.photos_count || 0 }})</span>
        </a>
      </div>
    </div>
  </section>

  <!-- BOOKING AVAILABILITY SECTION -->
  <section class="relative w-full py-20 bg-gradient-to-b from-[#AAC7D8]/10 via-[#DFEBF6]/40 to-[#E6E6E6]">
    <div class="max-w-3xl mx-auto px-4 text-center">
      <h2 class="text-3xl md:text-4xl font-serif font-bold text-primary-900 mb-6 tracking-widest uppercase drop-shadow-lg">Next Available Booking</h2>
      <p class="text-secondary-800 text-lg mb-8">
        <span v-if="nextBooking && nextBooking.date">{{ nextBooking.date }}</span>
        <span v-else>No upcoming bookings available.</span>
      </p>
    </div>
  </section>

  <!-- FOOTER -->
  <FooterSection />
</template>
