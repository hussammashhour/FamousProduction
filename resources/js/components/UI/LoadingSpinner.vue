<template>
  <div class="loading-spinner">
    <div class="spinner">
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
    </div>
    <p class="loading-text">{{ text }}</p>
  </div>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    default: 'Loading more posts...'
  }
});
</script>

<style scoped>
.loading-spinner {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  color: #6b7280;
}

.spinner {
  position: relative;
  width: 40px;
  height: 40px;
  margin-bottom: 1rem;
}

.spinner-ring {
  position: absolute;
  width: 100%;
  height: 100%;
  border: 3px solid transparent;
  border-top: 3px solid #3b82f6;
  border-radius: 50%;
  animation: spin 1.2s linear infinite;
}

.spinner-ring:nth-child(2) {
  border-top-color: #10b981;
  animation-delay: -0.4s;
}

.spinner-ring:nth-child(3) {
  border-top-color: #f59e0b;
  animation-delay: -0.8s;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.loading-text {
  font-size: 0.875rem;
  font-weight: 500;
  margin: 0;
}
</style>
