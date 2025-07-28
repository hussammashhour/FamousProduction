<template>
  <Navbar />
  <div class="text-center mt-10">
    <h1 class="text-4xl font-bold text-white">Welcome to Famous Production</h1>
    <p class="mt-4 text-gray-300">Let us capture your best moments.</p>
  </div>
</template>

<script>
import Navbar from './Navigation/Navbar.vue'
export default {
  name: 'HomePage',
  components: { Navbar }
}
</script>
