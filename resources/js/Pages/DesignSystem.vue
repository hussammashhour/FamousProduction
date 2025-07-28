<template>
  <div class="min-h-screen bg-secondary-50">
    <!-- Header -->
    <header class="bg-white shadow-soft border-b border-secondary-100">
      <div class="container-responsive py-8">
        <h1 class="text-4xl font-bold text-gradient mb-2">Design System</h1>
        <p class="text-secondary-600 text-lg">Comprehensive UI components and design tokens for Famous Production</p>
      </div>
    </header>

    <div class="container-responsive py-12">
      <!-- Color Palette -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Color Palette</h2>

        <div class="grid-responsive grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
          <!-- Primary Colors -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Primary Colors</h3>
            </template>
            <div class="space-y-3">
              <div v-for="shade in [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]" :key="shade" class="flex items-center">
                <div :class="`w-12 h-12 rounded-lg bg-primary-${shade} border border-secondary-200`"></div>
                <div class="ml-3">
                  <div class="font-medium">primary-{{ shade }}</div>
                  <div class="text-sm text-secondary-500">#{{ getColorHex(`primary-${shade}`) }}</div>
                </div>
              </div>
            </div>
          </BaseCard>

          <!-- Secondary Colors -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Secondary Colors</h3>
            </template>
            <div class="space-y-3">
              <div v-for="shade in [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]" :key="shade" class="flex items-center">
                <div :class="`w-12 h-12 rounded-lg bg-secondary-${shade} border border-secondary-200`"></div>
                <div class="ml-3">
                  <div class="font-medium">secondary-{{ shade }}</div>
                  <div class="text-sm text-secondary-500">#{{ getColorHex(`secondary-${shade}`) }}</div>
                </div>
              </div>
            </div>
          </BaseCard>

          <!-- Semantic Colors -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Semantic Colors</h3>
            </template>
            <div class="space-y-4">
              <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-success-500"></div>
                <div class="ml-3">
                  <div class="font-medium">Success</div>
                  <div class="text-sm text-secondary-500">success-500</div>
                </div>
              </div>
              <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-warning-500"></div>
                <div class="ml-3">
                  <div class="font-medium">Warning</div>
                  <div class="text-sm text-secondary-500">warning-500</div>
                </div>
              </div>
              <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-error-500"></div>
                <div class="ml-3">
                  <div class="font-medium">Error</div>
                  <div class="text-sm text-secondary-500">error-500</div>
                </div>
              </div>
            </div>
          </BaseCard>
        </div>
      </section>

      <!-- Typography -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Typography</h2>

        <div class="grid-responsive grid-cols-1 lg:grid-cols-2">
          <!-- Font Families -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Font Families</h3>
            </template>
            <div class="space-y-4">
              <div>
                <div class="text-2xl font-heading mb-2">Poppins (Headings)</div>
                <div class="text-sm text-secondary-500">font-heading</div>
              </div>
              <div>
                <div class="text-2xl font-sans mb-2">Inter (Body)</div>
                <div class="text-sm text-secondary-500">font-sans</div>
              </div>
              <div>
                <div class="text-2xl font-mono mb-2">JetBrains Mono (Code)</div>
                <div class="text-sm text-secondary-500">font-mono</div>
              </div>
            </div>
          </BaseCard>

          <!-- Font Sizes -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Font Sizes</h3>
            </template>
            <div class="space-y-3">
              <div v-for="size in ['xs', 'sm', 'base', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl']" :key="size" class="flex items-center">
                <div :class="`text-${size} font-medium`">Text {{ size.toUpperCase() }}</div>
                <div class="ml-4 text-sm text-secondary-500">text-{{ size }}</div>
              </div>
            </div>
          </BaseCard>
        </div>
      </section>

      <!-- Buttons -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Buttons</h2>

        <div class="space-y-8">
          <!-- Button Variants -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Button Variants</h3>
            </template>
            <div class="flex flex-wrap gap-4">
              <BaseButton variant="primary">Primary</BaseButton>
              <BaseButton variant="secondary">Secondary</BaseButton>
              <BaseButton variant="outline">Outline</BaseButton>
              <BaseButton variant="ghost">Ghost</BaseButton>
              <BaseButton variant="danger">Danger</BaseButton>
              <BaseButton variant="success">Success</BaseButton>
            </div>
          </BaseCard>

          <!-- Button Sizes -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Button Sizes</h3>
            </template>
            <div class="flex flex-wrap items-center gap-4">
              <BaseButton size="sm" variant="primary">Small</BaseButton>
              <BaseButton size="md" variant="primary">Medium</BaseButton>
              <BaseButton size="lg" variant="primary">Large</BaseButton>
              <BaseButton size="xl" variant="primary">Extra Large</BaseButton>
            </div>
          </BaseCard>

          <!-- Button States -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Button States</h3>
            </template>
            <div class="flex flex-wrap gap-4">
              <BaseButton variant="primary">Normal</BaseButton>
              <BaseButton variant="primary" disabled>Disabled</BaseButton>
              <BaseButton variant="primary" loading>Loading</BaseButton>
            </div>
          </BaseCard>
        </div>
      </section>

      <!-- Cards -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Cards</h2>

        <div class="grid-responsive grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
          <BaseCard>
            <template #header>
              <h3 class="text-lg font-semibold">Card with Header</h3>
            </template>
            <p class="text-secondary-600">This is a card with a header, body, and footer sections.</p>
            <template #footer>
              <div class="flex justify-end">
                <BaseButton variant="primary" size="sm">Action</BaseButton>
              </div>
            </template>
          </BaseCard>

          <BaseCard hover>
            <h3 class="text-lg font-semibold mb-3">Hover Card</h3>
            <p class="text-secondary-600">This card has a hover effect that lifts it up.</p>
          </BaseCard>

          <BaseCard shadow="strong">
            <h3 class="text-lg font-semibold mb-3">Strong Shadow</h3>
            <p class="text-secondary-600">This card has a stronger shadow effect.</p>
          </BaseCard>
        </div>
      </section>

      <!-- Form Elements -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Form Elements</h2>

        <div class="grid-responsive grid-cols-1 lg:grid-cols-2">
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Input Fields</h3>
            </template>
            <div class="space-y-4">
              <BaseInput
                v-model="formData.name"
                label="Name"
                placeholder="Enter your name"
                required
              />
              <BaseInput
                v-model="formData.email"
                type="email"
                label="Email"
                placeholder="Enter your email"
                error="Please enter a valid email address"
              />
              <BaseInput
                v-model="formData.phone"
                type="tel"
                label="Phone"
                placeholder="Enter your phone number"
                help="We'll use this to contact you"
              />
            </div>
          </BaseCard>

          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Alerts</h3>
            </template>
            <div class="space-y-4">
              <div class="alert alert-info">
                <strong>Info:</strong> This is an informational alert.
              </div>
              <div class="alert alert-success">
                <strong>Success:</strong> Your action was completed successfully.
              </div>
              <div class="alert alert-warning">
                <strong>Warning:</strong> Please review your input before proceeding.
              </div>
              <div class="alert alert-error">
                <strong>Error:</strong> Something went wrong. Please try again.
              </div>
            </div>
          </BaseCard>
        </div>
      </section>

      <!-- Responsive Design -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Responsive Design</h2>

        <div class="space-y-8">
          <!-- Responsive Text -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Responsive Text</h3>
            </template>
            <div class="space-y-4">
              <div class="text-responsive-xs">Extra Small (xs) - Responsive text that scales</div>
              <div class="text-responsive-sm">Small (sm) - Responsive text that scales</div>
              <div class="text-responsive-base">Base (base) - Responsive text that scales</div>
              <div class="text-responsive-lg">Large (lg) - Responsive text that scales</div>
              <div class="text-responsive-xl">Extra Large (xl) - Responsive text that scales</div>
            </div>
          </BaseCard>

          <!-- Responsive Grid -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Responsive Grid</h3>
            </template>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
              <div v-for="i in 8" :key="i" class="bg-primary-100 p-4 rounded-lg text-center">
                Grid Item {{ i }}
              </div>
            </div>
          </BaseCard>

          <!-- Breakpoints -->
          <BaseCard>
            <template #header>
              <h3 class="text-xl font-semibold">Breakpoints</h3>
            </template>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span>xs:</span>
                <span class="text-secondary-500">475px</span>
              </div>
              <div class="flex justify-between">
                <span>sm:</span>
                <span class="text-secondary-500">640px</span>
              </div>
              <div class="flex justify-between">
                <span>md:</span>
                <span class="text-secondary-500">768px</span>
              </div>
              <div class="flex justify-between">
                <span>lg:</span>
                <span class="text-secondary-500">1024px</span>
              </div>
              <div class="flex justify-between">
                <span>xl:</span>
                <span class="text-secondary-500">1280px</span>
              </div>
              <div class="flex justify-between">
                <span>2xl:</span>
                <span class="text-secondary-500">1536px</span>
              </div>
            </div>
          </BaseCard>
        </div>
      </section>

      <!-- Animations -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">Animations</h2>

        <div class="grid-responsive grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
          <BaseCard class="animate-fade-in">
            <h3 class="text-lg font-semibold mb-3">Fade In</h3>
            <p class="text-secondary-600">animate-fade-in</p>
          </BaseCard>

          <BaseCard class="animate-slide-up">
            <h3 class="text-lg font-semibold mb-3">Slide Up</h3>
            <p class="text-secondary-600">animate-slide-up</p>
          </BaseCard>

          <BaseCard class="animate-slide-down">
            <h3 class="text-lg font-semibold mb-3">Slide Down</h3>
            <p class="text-secondary-600">animate-slide-down</p>
          </BaseCard>

          <BaseCard class="animate-scale-in">
            <h3 class="text-lg font-semibold mb-3">Scale In</h3>
            <p class="text-secondary-600">animate-scale-in</p>
          </BaseCard>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import BaseButton from '@/components/UI/BaseButton.vue'
import BaseCard from '@/components/UI/BaseCard.vue'
import BaseInput from '@/components/UI/BaseInput.vue'

const formData = ref({
  name: '',
  email: '',
  phone: ''
})

// Mock function to get color hex values
const getColorHex = (colorClass) => {
  const colorMap = {
    'primary-50': 'f0f9ff',
    'primary-100': 'e0f2fe',
    'primary-200': 'bae6fd',
    'primary-300': '7dd3fc',
    'primary-400': '38bdf8',
    'primary-500': '0ea5e9',
    'primary-600': '0284c7',
    'primary-700': '0369a1',
    'primary-800': '075985',
    'primary-900': '0c4a6e',
    'secondary-50': 'f8fafc',
    'secondary-100': 'f1f5f9',
    'secondary-200': 'e2e8f0',
    'secondary-300': 'cbd5e1',
    'secondary-400': '94a3b8',
    'secondary-500': '64748b',
    'secondary-600': '475569',
    'secondary-700': '334155',
    'secondary-800': '1e293b',
    'secondary-900': '0f172a',
  }
  return colorMap[colorClass] || '000000'
}
</script>
