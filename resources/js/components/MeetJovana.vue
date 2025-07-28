<template>
  <section class="w-full bg-gradient-to-br from-[#DFEBF6] via-[#AAC7D8]/30 to-[#E6E6E6] py-16">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center md:items-start gap-12">
      <!-- Portrait -->
      <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center md:justify-start">
        <img
          src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80"
          alt="Famous Production team"
          class="rounded-lg shadow-lg w-64 h-80 object-cover object-center bg-white"
        />
      </div>
      <!-- Text Block -->
      <div class="flex-1 w-full md:w-2/3">
        <h2 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-6 uppercase tracking-wide font-serif">FAMOUS PRODUCTION</h2>
        <div class="text-secondary-900 text-base md:text-lg leading-relaxed space-y-4 mb-6">
          <p>Famous Production is a premier photography company based in Lebanon, specializing in capturing life's most precious moments with artistic vision and professional excellence.</p>
          <p>We combine creative storytelling with technical expertise to create stunning visual narratives that resonate with emotion and beauty. Our team of experienced photographers and creative professionals work together to deliver exceptional results for every project.</p>
          <p>From weddings and events to commercial photography and artistic portraits, we bring your vision to life through our lens. Every image tells a story, and we're here to capture yours.</p>
        </div>
        <div class="mb-8">
          <a href="#" class="underline text-primary-700 hover:text-primary-900 transition">Discover our world.</a>
        </div>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="/portfolio" class="px-8 py-3 bg-primary-700 text-white font-bold uppercase tracking-widest rounded shadow hover:bg-primary-800 transition text-center">Portfolio</a>
          <a href="/about" class="px-8 py-3 bg-secondary-700 text-white font-bold uppercase tracking-widest rounded shadow hover:bg-secondary-800 transition text-center">About</a>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.font-serif {
  font-family: 'Playfair Display', 'Georgia', serif;
}
</style>
