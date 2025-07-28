<template>
  <img
    :src="currentSrc"
    :alt="alt"
    :class="imgClass"
    @error="handleImageError"
    @load="handleImageLoad"
    :style="imgStyle"
  />
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  src: {
    type: String,
    required: true
  },
  alt: {
    type: String,
    default: 'Image'
  },
  imgClass: {
    type: String,
    default: ''
  },
  imgStyle: {
    type: Object,
    default: () => ({})
  },
  fallbackSrc: {
    type: String,
    default: '/images/default-image.svg'
  }
});

const emit = defineEmits(['error', 'load']);

const hasError = ref(false);
const isLoading = ref(true);

const currentSrc = computed(() => {
  if (hasError.value) {
    return props.fallbackSrc;
  }
  return props.src;
});

const handleImageError = () => {
  if (!hasError.value) {
    hasError.value = true;
    isLoading.value = false;
    emit('error', props.src);
  }
};

const handleImageLoad = () => {
  isLoading.value = false;
  emit('load', props.src);
};
</script>
 