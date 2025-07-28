<template>
  <MainLayout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <BaseCard>
        <h1 class="text-3xl font-bold mb-6 text-center">Privacy Policy</h1>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">1. Introduction</h2>
          <p class="text-gray-700">We value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">2. Information We Collect</h2>
          <p class="text-gray-700">We may collect information that you provide directly to us, such as your name, email address, and any other information you choose to provide.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">3. How We Use Your Information</h2>
          <p class="text-gray-700">We use your information to provide, maintain, and improve our services, communicate with you, and ensure the security of our platform.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">4. Sharing of Information</h2>
          <p class="text-gray-700">We do not sell or rent your personal information to third parties. We may share information with service providers who assist us in operating our platform, subject to confidentiality agreements.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">5. Data Security</h2>
          <p class="text-gray-700">We implement reasonable security measures to protect your information from unauthorized access, alteration, disclosure, or destruction.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">6. Your Rights</h2>
          <p class="text-gray-700">You have the right to access, update, or delete your personal information. Please contact us if you wish to exercise these rights.</p>
        </section>
        <section>
          <h2 class="text-xl font-semibold mb-2">7. Changes to This Policy</h2>
          <p class="text-gray-700">We may update this Privacy Policy from time to time. We encourage you to review this page periodically for any changes.</p>
        </section>
      </BaseCard>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
// Import BaseCard from the project's UI components
import BaseCard from '../components/UI/BaseCard.vue';
</script>

<style scoped>
/* Additional styling for the Privacy Policy page */
</style>
