<template>
  <div class="chosen-tags-card bg-white rounded-lg shadow-sm border border-secondary-200 p-4">
    <div class="flex items-center justify-between mb-3">
      <h3 class="text-lg font-semibold text-primary-700">Selected Tags</h3>
      <span class="text-sm text-secondary-500">{{ tags.length }} selected</span>
    </div>

    <div v-if="tags.length > 0" class="flex flex-wrap gap-2">
      <div
        v-for="tag in tags"
        :key="tag.id"
        class="flex items-center gap-2 bg-primary-100 text-primary-700 px-3 py-2 rounded-full text-sm font-medium"
      >
        <span>#{{ tag.name }}</span>
        <button
          @click="$emit('removeTag', tag)"
          class="text-primary-600 hover:text-primary-800 transition-colors"
          aria-label="Remove tag"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>

    <div v-else class="text-secondary-400 text-sm text-center py-2">
      No tags selected
    </div>
  </div>
</template>

<script setup>
defineProps({
  tags: {
    type: Array,
    default: () => []
  }
});

defineEmits(['removeTag']);
</script>

<style scoped>
.chosen-tags-card {
  transition: all 0.2s ease;
}

.chosen-tags-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
