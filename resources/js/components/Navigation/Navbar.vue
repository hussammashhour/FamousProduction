<template>
  <nav class="bg-white shadow-soft border-b border-secondary-100 sticky top-0 z-50">
    <div class="container-responsive">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link :href="route('dashboard')" class="flex items-center space-x-2">
            <img
              src="/images/famous_logoB.png"
              alt="Famous Production"
              class="h-8 w-auto"
            />
            <span class="text-xl font-bold text-gradient">Famous Production</span>
          </Link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <Link
              v-for="item in navigationItems"
              :key="item.name"
              :href="item.href"
              :class="[
                'px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200',
                $page.url.startsWith(item.href)
                  ? 'bg-primary-100 text-primary-700'
                  : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'
              ]"
            >
              {{ item.name }}
            </Link>
          </div>
        </div>

        <!-- User Menu -->
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Notifications -->
            <button class="p-2 rounded-full text-secondary-400 hover:text-secondary-500 hover:bg-secondary-100 transition-colors duration-200">
              <span class="sr-only">View notifications</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-3 relative">
              <div>
                <button
                  @click="userMenuOpen = !userMenuOpen"
                  class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  <span class="sr-only">Open user menu</span>
                  <img
                    class="h-8 w-8 rounded-full"
                    :src="$page.props.auth.user?.profile_photo_url || '/images/default-avatar.png'"
                    alt=""
                  />
                </button>
              </div>

              <!-- Dropdown menu -->
              <div
                v-show="userMenuOpen"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-strong bg-white ring-1 ring-black ring-opacity-5 py-1"
              >
                <Link
                  :href="route('profile.edit')"
                  class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100"
                  @click="userMenuOpen = false"
                >
                  Your Profile
                </Link>
                <Link
                  :href="route('dashboard')"
                  class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100"
                  @click="userMenuOpen = false"
                >
                  Dashboard
                </Link>
                <button
                  @click="logout"
                  class="block w-full text-left px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100"
                >
                  Sign out
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-secondary-400 hover:text-secondary-500 hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
          >
            <span class="sr-only">Open main menu</span>
            <svg
              :class="mobileMenuOpen ? 'hidden' : 'block'"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg
              :class="mobileMenuOpen ? 'block' : 'hidden'"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div :class="mobileMenuOpen ? 'block' : 'hidden'" class="md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-secondary-100">
        <Link
          v-for="item in navigationItems"
          :key="item.name"
          :href="item.href"
          :class="[
            'block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200',
            $page.url.startsWith(item.href)
              ? 'bg-primary-100 text-primary-700'
              : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'
          ]"
          @click="mobileMenuOpen = false"
        >
          {{ item.name }}
        </Link>
      </div>

      <!-- Mobile user menu -->
      <div class="pt-4 pb-3 border-t border-secondary-200">
        <div class="flex items-center px-4">
          <div class="flex-shrink-0">
            <img
              class="h-10 w-10 rounded-full"
              :src="$page.props.auth.user?.profile_photo_url || '/images/default-avatar.png'"
              alt=""
            />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-secondary-800">
              {{ $page.props.auth.user?.name }}
            </div>
            <div class="text-sm font-medium text-secondary-500">
              {{ $page.props.auth.user?.email }}
            </div>
          </div>
        </div>
        <div class="mt-3 px-2 space-y-1">
          <Link
            :href="route('profile.edit')"
            class="block px-3 py-2 rounded-md text-base font-medium text-secondary-700 hover:text-secondary-900 hover:bg-secondary-100"
            @click="mobileMenuOpen = false"
          >
            Your Profile
          </Link>
          <Link
            :href="route('dashboard')"
            class="block px-3 py-2 rounded-md text-base font-medium text-secondary-700 hover:text-secondary-900 hover:bg-secondary-100"
            @click="mobileMenuOpen = false"
          >
            Dashboard
          </Link>
          <button
            @click="logout"
            class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-secondary-700 hover:text-secondary-900 hover:bg-secondary-100"
          >
            Sign out
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const mobileMenuOpen = ref(false)
const userMenuOpen = ref(false)

const navigationItems = [
  { name: 'Dashboard', href: '/dashboard' },
  { name: 'Services', href: '/services' },
  { name: 'Bookings', href: '/bookings' },
  { name: 'Gallery', href: '/gallery' },
  { name: 'Contact', href: '/contact' },
]

const logout = () => {
  router.post(route('logout'))
  mobileMenuOpen.value = false
  userMenuOpen.value = false
}

// Close menus when clicking outside
const closeMenus = () => {
  mobileMenuOpen.value = false
  userMenuOpen.value = false
}

// Close menus on escape key
onMounted(() => {
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeMenus()
    }
  })
})
</script>
