<template>
  <div class="no-more-posts">
    <div class="no-more-icon">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="no-more-title">{{ title }}</h3>
    <p class="no-more-text">{{ text }}</p>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'You\'ve reached the end!'
  },
  text: {
    type: String,
    default: 'No more posts to load. Check back later for new content!'
  }
});
</script>

<style scoped>
.no-more-posts {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3rem 2rem;
  text-align: center;
  color: #6b7280;
}

.no-more-icon {
  margin-bottom: 1rem;
  color: #10b981;
}

.no-more-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.no-more-text {
  font-size: 1rem;
  line-height: 1.5;
  max-width: 400px;
  margin: 0;
}
</style>
