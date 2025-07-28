<template>
  <div>
    <HeroNavbar />
    <main>
      <slot />
    </main>
    <FooterSection />
  </div>
</template>

<script setup>
import HeroNavbar from '../components/HeroNavbar.vue';
import FooterSection from '../components/FooterSection.vue';
</script>
