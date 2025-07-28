<template>
  <MainLayout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <BaseCard>
        <h1 class="text-3xl font-bold mb-6 text-center">Terms of Service</h1>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">1. Acceptance of Terms</h2>
          <p class="text-gray-700">By accessing or using our services, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">2. Use of Service</h2>
          <p class="text-gray-700">You agree to use the service only for lawful purposes and in accordance with these terms. You are responsible for your conduct and any data, text, files, or other content you submit.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">3. User Accounts</h2>
          <p class="text-gray-700">You may be required to create an account to access certain features. You are responsible for maintaining the confidentiality of your account and password.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">4. Intellectual Property</h2>
          <p class="text-gray-700">All content, trademarks, and data on this site, including but not limited to software, databases, text, graphics, icons, and hyperlinks are the property of the company or its licensors.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">5. Termination</h2>
          <p class="text-gray-700">We reserve the right to suspend or terminate your access to the service at any time, without notice, for conduct that we believe violates these terms or is harmful to other users.</p>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">6. Changes to Terms</h2>
          <p class="text-gray-700">We may update these Terms of Service from time to time. Continued use of the service after changes constitutes acceptance of the new terms.</p>
        </section>
        <section>
          <h2 class="text-xl font-semibold mb-2">7. Contact Us</h2>
          <p class="text-gray-700">If you have any questions about these Terms, please contact us through our support page.</p>
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
/* Additional styling for the Terms page */
</style>
