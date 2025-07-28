<template>
  <MainLayout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-50 via-secondary-50 to-white py-20 px-4 overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-30 absolute -top-32 -left-32"></div>
        <div class="w-96 h-96 bg-secondary-200 rounded-full blur-3xl opacity-20 absolute -bottom-32 -right-32"></div>
      </div>
      <div class="relative z-10 max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h1 class="text-5xl md:text-6xl font-heading font-extrabold text-secondary-900 mb-4 drop-shadow-lg">Our Signature Photography Services</h1>
          <p class="text-xl text-secondary-700 mb-8 font-serif animate-fade-in-slow">From timeless weddings to creative portraits and impactful commercial shoots, Famous Production captures your story with artistry and care. Explore our most requested services below.</p>
          <a href="/portfolio" class="inline-block px-8 py-3 bg-primary-600 text-white font-bold uppercase tracking-widest rounded-full shadow hover:bg-primary-700 transition text-center">View Portfolio</a>
        </div>
        <div class="flex justify-center md:justify-end">
          <img src="/images/famous_logoB.png" alt="Famous Production Team" class="rounded-2xl shadow-2xl w-full max-w-xs object-cover bg-white p-6 border-4 border-white" />
        </div>
      </div>
    </section>

    <!-- Services Grid Section -->
    <section class="bg-white py-20">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-heading font-bold text-primary-700 mb-12 text-center">Our Services</h2>
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
          <BaseCard
            v-for="service in services"
            :key="service.id"
            class="relative group transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-2xl"
            hover
            @click="openSidebar(service)"
          >
            <template #header>
              <div class="flex items-center justify-between mb-2">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-100 text-primary-600 mr-2 shadow">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </span>
                <span v-if="!service.available" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-secondary-400 text-white ml-auto">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-1.414-1.414A9 9 0 105.636 18.364l1.414 1.414A9 9 0 1018.364 5.636z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2 2" /></svg>
                  Unavailable
                </span>
              </div>
            </template>
            <div>
              <h3 class="text-xl font-bold text-secondary-900 mb-2">{{ service.name }}</h3>
              <p class="text-secondary-700 mb-4 min-h-[48px]">{{ service.description }}</p>
              <div class="flex items-center justify-between mb-2">
                <span class="text-primary-700 font-bold text-lg">${{ service.price }}</span>
                <span class="text-xs text-secondary-500">{{ service.duration }}</span>
              </div>
            </div>
            <template #footer>
              <BaseButton
                variant="outline"
                size="md"
                :disabled="!service.available"
                class="w-full mt-2 rounded-full"
              >
                Learn More
              </BaseButton>
            </template>
          </BaseCard>
        </div>
        <div v-if="services.length === 0" class="flex justify-center mt-10">
          <span class="text-secondary-500">No services found.</span>
        </div>
      </div>
      <!-- Sidebar overlay -->
      <transition name="fade">
        <div v-if="showSidebar" class="fixed inset-0 z-40 bg-black bg-opacity-40 flex justify-end" @click.self="closeSidebar">
          <aside class="w-full max-w-2xl h-full bg-white shadow-xl p-10 overflow-y-auto relative flex flex-col rounded-l-3xl animate-fade-in">
            <button @click="closeSidebar" class="absolute top-4 right-4 text-secondary-500 hover:text-secondary-900 text-2xl">&times;</button>
            <div v-if="selectedService">
              <h2 class="text-3xl font-bold mb-2 text-primary-700 font-heading">{{ selectedService.name }}</h2>
              <p class="text-secondary-700 mb-4 text-lg">{{ selectedService.description }}</p>
              <div class="flex items-center gap-6 mb-4">
                <span class="text-xl font-bold text-primary-700">${{ selectedService.price }}</span>
                <span class="text-sm text-secondary-500">{{ selectedService.duration }}</span>
                <span v-if="!selectedService.available" class="text-xs bg-secondary-400 text-white px-2 py-1 rounded">Unavailable</span>
              </div>
              <BaseButton :to="`/booking?service_id=${selectedService.id}`" variant="primary" size="lg" class="rounded-full mb-6">Book Now</BaseButton>
              <h3 class="text-xl font-semibold mb-2 text-secondary-900">Reviews</h3>
              <div v-if="loadingReviews" class="text-secondary-500 mb-4">Loading reviews...</div>
              <div v-else-if="reviews.length === 0" class="text-secondary-500 mb-4">No reviews yet.</div>
              <div v-else class="space-y-4 mb-4">
                <div v-for="review in reviews" :key="review.id" class="border-b pb-3">
                  <div class="flex items-center gap-2 mb-1">
                    <span class="font-bold text-secondary-900">{{ review.client?.name || 'Anonymous' }}</span>
                    <span class="text-xs text-secondary-500">{{ new Date(review.created_at).toLocaleDateString() }}</span>
                  </div>
                  <div class="flex items-center gap-1 mb-1">
                    <span v-for="n in review.rating" :key="n" class="text-yellow-400">★</span>
                    <span v-for="n in (5 - review.rating)" :key="n" class="text-gray-300">★</span>
                  </div>
                  <p class="text-secondary-700">{{ review.comment }}</p>
                </div>
              </div>
            </div>
          </aside>
        </div>
      </transition>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-gradient-to-r from-primary-50 via-secondary-50 to-white py-16 border-t border-b border-secondary-200">
      <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
        <div class="flex justify-center md:justify-start">
          <img src="/images/famous_logoW.png" alt="Why Choose Us" class="rounded-2xl shadow-xl w-full max-w-sm object-cover bg-secondary-900 p-6 border-4 border-white" />
        </div>
        <div>
          <h2 class="text-2xl font-heading font-bold text-primary-700 mb-4">Why Choose Famous Production?</h2>
          <ul class="space-y-3 text-secondary-700">
            <li class="flex items-start"><span class="w-3 h-3 mt-2 mr-3 rounded-full bg-primary-400"></span> <span>Creative photographers with a passion for storytelling</span></li>
            <li class="flex items-start"><span class="w-3 h-3 mt-2 mr-3 rounded-full bg-primary-400"></span> <span>State-of-the-art equipment and editing</span></li>
            <li class="flex items-start"><span class="w-3 h-3 mt-2 mr-3 rounded-full bg-primary-400"></span> <span>Personalized approach for every client and event</span></li>
            <li class="flex items-start"><span class="w-3 h-3 mt-2 mr-3 rounded-full bg-primary-400"></span> <span>Fast delivery and exceptional customer service</span></li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Call-To-Action Section -->
    <section class="relative py-20 bg-primary-700 text-white text-center">
      <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
      <div class="relative z-10 max-w-2xl mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-heading font-bold mb-4">Let's Start Your Project</h2>
        <p class="text-xl mb-8 font-serif">Ready to take your business to the next level? Contact our team today for a free consultation.</p>
        <a href="/contact" class="inline-block px-8 py-3 bg-white text-primary-700 font-bold uppercase tracking-widest rounded-full shadow hover:bg-secondary-100 transition text-center">Contact Us</a>
      </div>
    </section>

    <!-- Clients Logos Section -->
    <section class="bg-white py-12">
      <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-wrap items-center justify-center gap-8">
          <img v-for="n in 6" :key="n" :src="`https://dummyimage.com/120x40/cccccc/444444&text=Logo+${n}`" alt="Client Logo" class="h-10 w-auto grayscale opacity-70 hover:opacity-100 transition" />
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import MainLayout from '../Layouts/MainLayout.vue'
import BaseCard from '../components/UI/BaseCard.vue'
import BaseButton from '../components/UI/BaseButton.vue'

const page = usePage()
const services = computed(() => page.props.services || [])

const showSidebar = ref(false)
const selectedService = ref(null)
const reviews = ref([])
const loadingReviews = ref(false)

async function openSidebar(service) {
  selectedService.value = service
  showSidebar.value = true
  reviews.value = []
  loadingReviews.value = true
  try {
    const res = await fetch(`/api/reviews?service_id=${service.id}`)
    const data = await res.json()
    reviews.value = data.data
  } catch (e) {
    reviews.value = []
  } finally {
    loadingReviews.value = false
  }
}
function closeSidebar() {
  showSidebar.value = false
  selectedService.value = null
  reviews.value = []
}
</script>

<style scoped>
.bg-error-500 {
  background-color: #a3a3a3;
}
</style>
