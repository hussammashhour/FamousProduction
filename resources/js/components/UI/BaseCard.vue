<template>
  <div :class="cardClasses">
    <div v-if="$slots.header" class="card-header">
      <slot name="header" />
    </div>

    <div class="card-body">
      <slot />
    </div>

    <div v-if="$slots.footer" class="card-footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  padding: {
    type: String,
    default: 'normal',
    validator: (value) => ['none', 'small', 'normal', 'large'].includes(value)
  },
  shadow: {
    type: String,
    default: 'soft',
    validator: (value) => ['none', 'soft', 'medium', 'strong'].includes(value)
  },
  hover: {
    type: Boolean,
    default: false
  }
})

const cardClasses = computed(() => {
  const baseClasses = 'card'
  const paddingClasses = {
    none: 'p-0',
    small: 'p-4',
    normal: '',
    large: 'p-8'
  }
  const shadowClasses = {
    none: 'shadow-none',
    soft: 'shadow-soft',
    medium: 'shadow-medium',
    strong: 'shadow-strong'
  }
  const hoverClasses = props.hover ? 'hover-lift' : ''

  return [
    baseClasses,
    paddingClasses[props.padding],
    shadowClasses[props.shadow],
    hoverClasses
  ].filter(Boolean).join(' ')
})
</script>
