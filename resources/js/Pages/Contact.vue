<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import HeroNavbar from '@/components/HeroNavbar.vue';
</script>

<template>
  <MainLayout>
    <div class="bg-gradient-to-br from-[#f5efe7] via-[#f7f6fa] to-[#e3e6f3] min-h-screen w-full">
      <!-- Navbar -->
      <!-- <HeroNavbar /> -->
      <!-- Spacer -->
      <!-- <div class="h-12 md:h-20"></div> -->
      <!-- Hero Section -->
      <section class="relative w-full min-h-[60vh] md:min-h-[70vh] flex items-center justify-center overflow-hidden">
        <img
          src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=1200&q=80"
          alt="Famous Production Studio"
          class="absolute inset-0 w-full h-full object-cover object-center"
        />
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 flex flex-col items-center justify-center w-full text-center h-full">
          <h1 class="text-5xl md:text-6xl font-heading font-extrabold text-white drop-shadow-lg mb-4 px-4 leading-tight">Let's Connect</h1>
          <p class="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto mb-6 font-serif animate-fade-in-slow">We'd love to hear from you! Whether it's a booking, collaboration, or just a hello, reach out and let's create something beautiful together.</p>
        </div>
      </section>

      <!-- Contact Info & Intro Section -->
      <section class="max-w-4xl mx-auto px-4 py-16 text-center">
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-primary-700 mb-6">Thank you for your interest in our work.</h2>
        <p class="text-secondary-800 text-lg md:text-xl mb-6">For inquiries, collaborations, licensing, or just to say hi, use the form below or connect with us on social media.</p>
        <div class="flex flex-wrap justify-center gap-4 mb-8">
          <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full font-semibold text-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 01-8 0 4 4 0 018 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/></svg> Bookings</span>
          <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full font-semibold text-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m0 0l4 4 4-4"/></svg> Collaborations</span>
          <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full font-semibold text-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg> Licensing</span>
          <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full font-semibold text-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> General Inquiries</span>
        </div>
        <div class="text-secondary-700 text-lg md:text-xl mb-2">Use the contact form below to get in touch. We look forward to hearing from you!</div>
      </section>

      <!-- Contact Form Section -->
      <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="bg-white/90 rounded-2xl shadow-2xl p-8 md:p-16">
          <h3 class="text-2xl md:text-3xl font-heading font-bold text-primary-700 mb-8 text-center">Contact Form</h3>
          <form class="space-y-8">
            <div class="flex flex-col md:flex-row gap-8">
              <div class="flex-1">
                <label class="block text-secondary-700 text-base font-heading mb-3">I'm writing to you</label>
                <div class="flex gap-8">
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="radio" name="messageType" value="personal" class="form-radio accent-primary-600 w-5 h-5" checked />
                    <span>Personal message</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="radio" name="messageType" value="business" class="form-radio accent-primary-600 w-5 h-5" />
                    <span>Business message</span>
                  </label>
                </div>
              </div>
              <div class="flex-1">
                <label class="block text-secondary-700 text-base font-heading mb-3">I'm interested in</label>
                <div class="flex flex-wrap gap-x-6 gap-y-2">
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="general" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>General Inquiry</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="wedding" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>Wedding/Event</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="commercial" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>Commercial Project</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="licensing" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>Licensing</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="prints" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>Prints</span>
                  </label>
                  <label class="inline-flex items-center gap-2 text-lg">
                    <input type="checkbox" name="interest" value="collaboration" class="form-checkbox accent-primary-600 w-5 h-5" />
                    <span>Collaboration</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <input type="text" placeholder="Name" class="form-input text-lg" required />
              <input type="email" placeholder="E-mail" class="form-input text-lg" required />
              <input type="text" placeholder="Website" class="form-input text-lg" />
              <input type="text" placeholder="Where are you from?" class="form-input text-lg" />
            </div>
            <textarea placeholder="Write your message..." class="form-input w-full min-h-[120px] resize-vertical text-lg" required></textarea>
            <div class="flex justify-end">
              <button type="submit" class="px-10 py-3 bg-primary-600 text-white text-lg font-bold uppercase tracking-widest rounded-full shadow hover:bg-primary-700 transition">Send</button>
            </div>
            <div class="text-xs text-secondary-400 mt-2 text-center">This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.</div>
          </form>
        </div>
      </section>

      <!-- Instagram Feed/Handle Section -->
      <section class="max-w-5xl mx-auto px-4 py-10">
        <div class="text-center mb-4">
          <a href="https://instagram.com/famous.production.lb" target="_blank" class="text-lg font-heading text-primary-600 hover:underline flex items-center justify-center gap-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5"/><circle cx="12" cy="12" r="5"/><path d="M17 7h.01"/></svg>@famous.production.lb</a>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
          <div v-for="n in 6" :key="n" class="w-32 h-32 bg-secondary-200 rounded-lg overflow-hidden flex items-center justify-center hover:scale-105 transition-transform duration-200 cursor-pointer">
            <span class="text-secondary-400 text-2xl font-bold">IMG</span>
          </div>
        </div>
      </section>
    </div>
  </MainLayout>
</template>

<style scoped>
.form-input {
  @apply w-full px-4 py-2 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200;
}
</style>
