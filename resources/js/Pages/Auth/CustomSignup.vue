<template>
  <div class="signup-container">
    <!-- Left: Visual/Slider Panel -->
    <div class="signup-slider-panel">
      <div class="slider-wrapper" @touchstart="onTouchStart" @touchend="onTouchEnd">
        <div
          class="slide"
          v-for="(slide, i) in slides"
          :key="i"
          :class="{ active: i === currentSlide }"
        >
          <img :src="slide.img" class="slide-img" :alt="slide.heading" />
          <div class="slide-text">
            <h2 class="slide-heading">{{ slide.heading }}</h2>
            <p class="slide-desc">{{ slide.desc }}</p>
          </div>
        </div>
        <div class="slider-dots">
          <span
            v-for="(slide, i) in slides"
            :key="i"
            :class="{ dot: true, active: i === currentSlide }"
            @click="goToSlide(i)"
          ></span>
        </div>
      </div>
    </div>
    <!-- Right: Form Panel -->
    <div class="signup-form-panel">
      <div class="form-header">
        <h1>Create Your Account</h1>
        <p>Join us to access exclusive services and manage your bookings.</p>
      </div>

      <!-- Google Sign Up Button -->
      <div class="google-signup-section">
        <a
          :href="route('google.login')"
          class="google-signup-btn"
        >
          <svg class="google-icon" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          <span>Continue with Google</span>
        </a>

        <div class="divider">
          <span>or</span>
        </div>
      </div>

      <form @submit.prevent="submitForm" class="signup-form" enctype="multipart/form-data">
        <div class="form-row">
          <div style="flex:1;display:flex;flex-direction:column;">
            <input v-model="form.first_name" type="text" placeholder="First Name" required />
            <div v-if="errors.first_name" class="error-text">{{ errors.first_name }}</div>
          </div>
          <div style="flex:1;display:flex;flex-direction:column;">
            <input v-model="form.last_name" type="text" placeholder="Last Name" required />
            <div v-if="errors.last_name" class="error-text">{{ errors.last_name }}</div>
          </div>
        </div>
        <div class="form-row">
          <input v-model="form.email" type="email" placeholder="Email Address" required />
        </div>
        <div v-if="errors.email" class="error-text">{{ errors.email }}</div>
        <div class="form-row">
          <div style="flex:1;display:flex;flex-direction:column;">
            <input v-model="form.password" type="password" placeholder="Password" required />
            <div v-if="errors.password" class="error-text">{{ errors.password }}</div>
          </div>
          <div style="flex:1;display:flex;flex-direction:column;">
            <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" required />
          </div>
        </div>
        <div class="form-row">
          <input v-model="form.birthdate" type="date" placeholder="Birthdate" required />
        </div>
        <div v-if="errors.birthdate" class="error-text">{{ errors.birthdate }}</div>
        <div class="form-row">
          <div class="phone-group" style="flex:1;display:flex;flex-direction:column;">
            <div style="display:flex;gap:0.5rem;">
              <select v-model="form.country_code" class="country-code-select">
                <option v-for="country in countries" :key="country.code" :value="country.dial_code">
                  {{ country.flag }} {{ country.name }} ({{ country.dial_code }})
                </option>
              </select>
              <input v-model="form.phone" type="tel" placeholder="Phone Number" required style="flex:1;" />
            </div>
            <div v-if="errors.phone" class="error-text">{{ errors.phone }}</div>
          </div>
        </div>
        <div class="form-row">
          <input v-model="form.address" type="text" placeholder="Address" required />
        </div>
        <div v-if="errors.address" class="error-text">{{ errors.address }}</div>
        <div class="form-row">
          <label class="avatar-label">
            <span>Avatar:</span>
            <input type="file" accept="image/*" @change="onAvatarChange" />
          </label>
          <img v-if="avatarPreview" :src="avatarPreview" class="avatar-preview" alt="Avatar Preview" />
        </div>
        <div v-if="errors.avatar" class="error-text">{{ errors.avatar }}</div>
        <div v-if="errors.latitude" class="error-text">{{ errors.latitude }}</div>
        <div v-if="errors.longitude" class="error-text">{{ errors.longitude }}</div>
        <div class="form-row consent-row">
          <input type="checkbox" v-model="form.consent" required />
          <label>
            I agree to the
            <a href="/terms" class="blue-link" target="_blank">Terms of Service</a>
            and
            <a href="/privacy" class="blue-link" target="_blank">Privacy Policy</a>.
          </label>
        </div>
        <button class="primary-btn" type="submit" :disabled="loading">
          <span v-if="loading">Signing Up...</span>
          <span v-else>Sign Up</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const errors = page.props.errors || {};

const slides = [
  {
    img: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=600&q=80',
    heading: 'Showcase Your Work',
    desc: 'Highlight your best projects and attract new clients with a stunning portfolio.',
  },
  {
    img: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
    heading: 'Book Services Easily',
    desc: 'Seamlessly book and manage company services online, anytime, anywhere.',
  },
  {
    img: 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80',
    heading: 'Stay Connected',
    desc: 'Receive updates, announcements, and support directly in your dashboard.',
  },
  {
    img: 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80',
    heading: 'Secure & Private',
    desc: 'Your data is protected with industry-leading security and privacy standards.',
  },
  {
    img: 'https://images.unsplash.com/photo-1465101178521-c1a9136a3fdc?auto=format&fit=crop&w=600&q=80',
    heading: 'Grow With Us',
    desc: 'Join a growing community and unlock new opportunities for your business.',
  },
];

const currentSlide = ref(0);
let interval = null;

function goToSlide(i) {
  currentSlide.value = i;
}

function nextSlide() {
  currentSlide.value = (currentSlide.value + 1) % slides.length;
}

onMounted(() => {
  interval = setInterval(nextSlide, 4000);
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      pos => {
        lat.value = pos.coords.latitude;
        lng.value = pos.coords.longitude;
      },
      err => {},
      { enableHighAccuracy: true, timeout: 10000 }
    );
  }
});
onUnmounted(() => {
  clearInterval(interval);
});

// Touch support for mobile
let startX = 0;
function onTouchStart(e) {
  startX = e.touches[0].clientX;
}
function onTouchEnd(e) {
  const endX = e.changedTouches[0].clientX;
  if (endX - startX > 50) {
    // swipe right
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length;
  } else if (startX - endX > 50) {
    // swipe left
    nextSlide();
  }
}

const countries = [
  { code: 'US', name: 'United States', dial_code: '+1', flag: '🇺🇸' },
  { code: 'GB', name: 'United Kingdom', dial_code: '+44', flag: '🇬🇧' },
  { code: 'FR', name: 'France', dial_code: '+33', flag: '🇫🇷' },
  { code: 'DE', name: 'Germany', dial_code: '+49', flag: '🇩🇪' },
  { code: 'SA', name: 'Saudi Arabia', dial_code: '+966', flag: '🇸🇦' },
  { code: 'EG', name: 'Egypt', dial_code: '+20', flag: '🇪🇬' },
  // ...add more as needed
];

const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  birthdate: '',
  country_code: countries[0].dial_code,
  phone: '',
  address: '',
  consent: false,
});
const avatar = ref(null);
const avatarPreview = ref(null);
const loading = ref(false);
const lat = ref(null);
const lng = ref(null);

function onAvatarChange(e) {
  const file = e.target.files[0];
  avatar.value = file;
  if (file) {
    const reader = new FileReader();
    reader.onload = ev => { avatarPreview.value = ev.target.result; };
    reader.readAsDataURL(file);
  } else {
    avatarPreview.value = null;
  }
}

function submitForm() {
  if (!form.value.consent) return;
  loading.value = true;
  const data = new FormData();
  data.append('first_name', form.value.first_name);
  data.append('last_name', form.value.last_name);
  data.append('email', form.value.email);
  data.append('password', form.value.password);
  data.append('password_confirmation', form.value.password_confirmation);
  data.append('birthdate', form.value.birthdate);
  data.append('phone', form.value.country_code + form.value.phone);
  data.append('address', form.value.address);
  if (avatar.value) data.append('avatar', avatar.value);
  if (lat.value !== null) data.append('latitude', lat.value);
  if (lng.value !== null) data.append('longitude', lng.value);
  router.post('/signup', data, {
    forceFormData: true,
    onFinish: () => loading.value = false,
    onSuccess: () => loading.value = false,
  });
}
</script>

<style scoped>
.signup-container {
  display: flex;
  min-height: 100vh;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.signup-slider-panel {
  flex: 1;
  background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  position: relative;
  overflow: hidden;
}
.slider-wrapper {
  width: 100%;
  max-width: 420px;
  height: 480px;
  margin: 0 auto;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  touch-action: pan-y;
}
.slide {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  opacity: 0;
  transition: opacity 0.7s cubic-bezier(.4,0,.2,1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: left;
  z-index: 1;
  pointer-events: none;
}
.slide.active {
  opacity: 1;
  z-index: 2;
  pointer-events: auto;
}
.slide-img {
  width: 100%;
  max-width: 320px;
  height: 180px;
  object-fit: cover;
  border-radius: 1.2rem;
  margin-bottom: 2rem;
  box-shadow: 0 8px 32px rgba(30,64,175,0.18);
}
.slide-text {
  padding: 0 1rem;
}
.slide-heading {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #fff;
}
.slide-desc {
  font-size: 1.05rem;
  color: #e0e7ef;
  opacity: 0.95;
}
.slider-dots {
  position: absolute;
  bottom: 1.5rem;
  left: 0; right: 0;
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  z-index: 3;
}
.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #fff6;
  border: 2px solid #fff;
  cursor: pointer;
  transition: background 0.2s;
}
.dot.active {
  background: #fff;
}
.signup-form-panel {
  flex: 1;
  background: #fff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 3rem 2rem;
  box-shadow: -2px 0 8px rgba(30, 64, 175, 0.05);
}
.form-header h1 {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}
.form-header p {
  font-size: 1.1rem;
  color: #64748b;
  margin-bottom: 2rem;
}
.signup-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}
.form-row {
  display: flex;
  gap: 1rem;
}
.form-row input {
  flex: 1;
  padding: 0.75rem 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  font-size: 1rem;
  background: #f9fafb;
  color: #1e293b;
}
.form-row input::placeholder {
  color: #94a3b8;
  font-weight: 400;
  font-size: 0.95rem;
}
.consent-row {
  align-items: center;
  gap: 0.5rem;
  font-size: 0.95rem;
}
.blue-link {
  color: #2563eb;
  text-decoration: underline;
  font-weight: 500;
}
.primary-btn {
  width: 100%;
  padding: 0.9rem 0;
  background: #2563eb;
  color: #fff;
  font-weight: bold;
  border: none;
  border-radius: 0.375rem;
  font-size: 1.1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.primary-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
.primary-btn:hover:not(:disabled) {
  background: #1e40af;
}
.phone-group {
  display: flex;
  gap: 0.5rem;
  width: 100%;
}
.country-code-select {
  min-width: 110px;
  padding: 0.75rem 0.5rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  background: #f9fafb;
  font-size: 1rem;
}
.avatar-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
}
.avatar-preview {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  margin-left: 1rem;
  border: 2px solid #2563eb;
}

/* Google Sign Up Styles */
.google-signup-section {
  margin-bottom: 2rem;
}

.google-signup-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  background: #fff;
  color: #374151;
  font-size: 1rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.google-signup-btn:hover {
  background: #f9fafb;
  border-color: #d1d5db;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.google-icon {
  width: 20px;
  height: 20px;
  margin-right: 0.75rem;
}

.divider {
  position: relative;
  text-align: center;
  margin: 1.5rem 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: #e5e7eb;
}

.divider span {
  background: #fff;
  padding: 0 1rem;
  color: #6b7280;
  font-size: 0.875rem;
}

@media (max-width: 1100px) {
  .signup-container {
    flex-direction: column;
  }
  .signup-slider-panel,
  .signup-form-panel {
    flex: unset;
    width: 100%;
    min-height: 40vh;
    max-width: 100vw;
    box-shadow: none;
  }
  .slider-wrapper {
    max-width: 100vw;
    height: 320px;
  }
}
@media (max-width: 600px) {
  .slider-wrapper {
    height: 200px;
  }
  .slide-img {
    max-width: 90vw;
    height: 100px;
  }
  .slide-heading {
    font-size: 1.1rem;
  }
  .slide-desc {
    font-size: 0.95rem;
  }
  .signup-form-panel {
    padding: 1.5rem 0.5rem;
  }
}
</style>
