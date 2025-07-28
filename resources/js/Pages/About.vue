<template>
  <MainLayout>
    <div class="bg-gradient-to-br from-[#f5efe7] via-[#f7f6fa] to-[#e3e6f3] min-h-screen w-full">
      <!-- Hero Section -->
      <section class="relative flex flex-col items-center justify-center text-center py-20 px-4">
        <div class="absolute inset-0 pointer-events-none">
          <div class="w-64 h-64 bg-primary-100 rounded-full blur-3xl opacity-30 absolute -top-24 -left-24"></div>
          <div class="w-96 h-96 bg-secondary-200 rounded-full blur-3xl opacity-20 absolute -bottom-32 -right-32"></div>
        </div>
        <img
          src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80"
          alt="Famous Production team"
          class="relative z-10 w-40 h-40 md:w-56 md:h-56 rounded-full object-cover shadow-2xl border-8 border-white mb-8 animate-fade-in"
        />
        <h1 class="relative z-10 text-5xl md:text-6xl font-extrabold text-secondary-900 mb-4 font-heading tracking-tight drop-shadow-lg">
          Famous Production
        </h1>
        <p class="relative z-10 text-xl md:text-2xl text-secondary-700 max-w-2xl mx-auto mb-6 font-serif animate-fade-in-slow">
          Capturing Lebanon's most beautiful moments with artistry, passion, and heart.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-4">
          <a href="/portfolio" class="px-8 py-3 bg-primary-600 text-white font-bold uppercase tracking-widest rounded-full shadow hover:bg-primary-700 transition text-center">View Portfolio</a>
          <a href="/contact" class="px-8 py-3 bg-secondary-900 text-white font-bold uppercase tracking-widest rounded-full shadow hover:bg-secondary-800 transition text-center">Contact Us</a>
        </div>
      </section>
      <BrandInfinityBar :brands="brands" />

      <!-- About/Story Section -->
      <section class="max-w-5xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-6 font-heading">Our Story</h2>
          <div class="text-secondary-900 text-lg leading-relaxed space-y-4">
            <p>Famous Production is a leading photography company based in Lebanon, dedicated to capturing life's most beautiful moments with artistic vision and professional excellence.</p>
            <p>We specialize in a wide range of photography services including <span class="font-semibold text-primary-600">weddings</span>, <span class="font-semibold text-primary-600">events</span>, <span class="font-semibold text-primary-600">commercial photography</span>, <span class="font-semibold text-primary-600">portraits</span>, and <span class="font-semibold text-primary-600">fine art</span>. Our team combines creative storytelling with technical expertise to deliver exceptional results.</p>
            <blockquote class="border-l-4 border-primary-400 pl-4 italic text-secondary-700 bg-primary-50/40 rounded py-2">"Photography is the story we fail to put into words."</blockquote>
            <p>With years of experience, we've built a reputation for <span class="font-semibold text-primary-600">quality</span>, <span class="font-semibold text-primary-600">creativity</span>, and <span class="font-semibold text-primary-600">reliability</span>. Our work has been featured in various publications and we've had the privilege of working with numerous satisfied clients across Lebanon and beyond.</p>
          </div>
        </div>
        <div class="flex flex-col gap-8 items-center">
          <img
            src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80"
            alt="Our team at work"
            class="rounded-2xl shadow-xl w-full max-w-xs object-cover border-4 border-white"
          />
          <div class="flex flex-col gap-2 text-center">
            <span class="text-primary-700 font-bold text-lg">Available for bookings, events, and creative collaborations throughout Lebanon and the region.</span>
          </div>
        </div>
      </section>

      <!-- Why Choose Us Section -->
      <section class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-secondary-900 mb-8 uppercase tracking-wide text-center">Why Choose Famous Production?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
          <div class="bg-white/80 rounded-xl shadow p-6 flex flex-col items-center text-center">
            <svg class="w-10 h-10 text-primary-600 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span class="font-bold text-lg mb-1">Creative Vision</span>
            <span class="text-secondary-700">Artistry and storytelling in every shot.</span>
          </div>
          <div class="bg-white/80 rounded-xl shadow p-6 flex flex-col items-center text-center">
            <svg class="w-10 h-10 text-primary-600 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="font-bold text-lg mb-1">Professionalism</span>
            <span class="text-secondary-700">Reliable, punctual, and client-focused.</span>
          </div>
          <div class="bg-white/80 rounded-xl shadow p-6 flex flex-col items-center text-center">
            <svg class="w-10 h-10 text-primary-600 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg>
            <span class="font-bold text-lg mb-1">Experience</span>
            <span class="text-secondary-700">Years of expertise in diverse photography fields.</span>
          </div>
          <div class="bg-white/80 rounded-xl shadow p-6 flex flex-col items-center text-center">
            <svg class="w-10 h-10 text-primary-600 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
            <span class="font-bold text-lg mb-1">Client Satisfaction</span>
            <span class="text-secondary-700">Hundreds of happy clients and glowing testimonials.</span>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section class="max-w-4xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-secondary-900 mb-8 uppercase tracking-wide text-center">Client Testimonials</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div v-for="t in testimonials" :key="t.name" class="bg-white/90 rounded-2xl shadow-lg p-8 flex flex-col justify-between">
            <p class="text-lg italic text-secondary-800 mb-4">"{{ t.quote }}"</p>
            <div class="text-right text-primary-700 font-semibold">— {{ t.name }}</div>
          </div>
        </div>
      </section>

      <!-- Featured On / Publications Section -->
      <section class="max-w-5xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-secondary-900 mb-8 uppercase tracking-wide text-center">Featured On / Publications</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8 items-center justify-items-center">
          <div v-for="n in 8" :key="n" class="w-32 h-16 bg-secondary-200 rounded flex items-center justify-center text-secondary-500 text-lg font-bold opacity-60 hover:opacity-100 hover:bg-primary-100 transition-all duration-200 cursor-pointer">
            Logo
          </div>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import BrandInfinityBar from '@/components/BrandInfinityBar.vue';

const brands = [
  { url: '/images/brands/sony_logo.png', alt: 'Sony' },
  { url: '/images/brands/leica_logo.png', alt: 'Leica' },
  { url: '/images/brands/samsung_logo.png', alt: 'Samsung' },
  { url: '/images/brands/nikon_logo.png', alt: 'Nikon' },
  { url: '/images/brands/canon_logo.png', alt: 'Canon' },
  { url: '/images/brands/adobe_logo.png', alt: 'Adobe' },
  { url: '/images/brands/panasonic_logo.png', alt: 'Panasonic' },
];

const testimonials = [
  {
    name: 'Sarah & Michael',
    quote: 'Famous Production captured our wedding day perfectly! The team was professional, creative, and made us feel so comfortable. The photos exceeded our expectations and we couldn\'t be happier.'
  },
  {
    name: 'Beirut Events Co.',
    quote: 'Working with Famous Production for our corporate events has been exceptional. Their attention to detail and ability to capture the essence of our brand has made them our go-to photography partner.'
  },
  {
    name: 'Layla Hassan',
    quote: 'The portrait session with Famous Production was amazing! They made me feel confident and beautiful, and the final images are absolutely stunning. Highly recommend their artistic vision.'
  },
  {
    name: 'Lebanon Fashion Week',
    quote: 'Famous Production delivered outstanding coverage of our fashion week events. Their creative approach and technical expertise brought our runway shows to life in the most beautiful way.'
  },
  {
    name: 'Ahmad & Mariam',
    quote: 'From engagement to wedding day, Famous Production has been incredible. They truly understand how to tell our love story through their lens. The results are magical and we\'re forever grateful.'
  },
];
</script>

<style scoped>
.font-heading {
  font-family: 'Playfair Display', 'Georgia', serif;
}
.form-input {
  @apply w-full px-4 py-2 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200;
}
</style>
