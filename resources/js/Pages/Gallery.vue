<template>
  <MainLayout>
    <div class="gallery-page flex flex-col lg:flex-row min-h-screen">
      <!-- Left: Post List -->
      <div :class="['flex-1 transition-all duration-300', selectedPost ? 'lg:w-1/2' : 'w-full']">
      <div class="gallery-container">
        <!-- Header Text -->
        <div class="gallery-header">
          <h2 class="gallery-title">Discover Amazing Photography</h2>
          <p class="gallery-subtitle">Explore our collection of stunning photos and creative moments captured by talented photographers.</p>
        </div>

          <!-- Chosen Tags Card (mobile) -->
          <div v-if="chosenTags.length > 0" class="block lg:hidden mb-4">
            <ChosenTagsCard :tags="chosenTags" @removeTag="removeTag" />
        </div>

        <!-- Posts Grid -->
          <div v-if="filteredPosts.length > 0" class="posts-grid">
          <div
              v-for="post in filteredPosts"
            :key="post.id"
              class="post-card cursor-pointer hover:shadow-xl transition-shadow duration-200"
              @click="selectPost(post)"
          >
            <!-- Post Header -->
            <div class="post-header">
              <div class="post-author">
                <img :src="post.user?.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face'" :alt="post.user?.name" class="author-avatar">
                <div class="author-info">
                  <h3 class="author-name">{{ post.user?.first_name }} {{ post.user?.last_name }}</h3>
                  <span class="post-time">{{ formatDate(post.created_at) }}</span>
                </div>
              </div>
            </div>

            <!-- Post Caption -->
            <div v-if="post.caption" class="post-caption">
              <p>{{ post.caption }}</p>
            </div>

            <!-- Post Images -->
            <div v-if="post.photos && post.photos.length > 0" class="post-images">
              <div
                v-if="post.photos.length === 1"
                class="single-image"
                @click="openPhotoModal(post.photos[0])"
              >
                <img :src="post.photos[0].url" :alt="post.photos[0].caption" class="post-image">
              </div>

              <div v-else-if="post.photos.length === 2" class="two-images">
                <div
                  v-for="(photo, index) in post.photos"
                  :key="photo.id"
                  class="two-image-item"
                  @click="openPhotoModal(photo)"
                >
                  <img :src="photo.url" :alt="photo.caption" class="post-image">
                </div>
              </div>

              <div v-else-if="post.photos.length === 3" class="three-images">
                <div
                  class="three-image-main"
                  @click="openPhotoModal(post.photos[0])"
                >
                  <img :src="post.photos[0].url" :alt="post.photos[0].caption" class="post-image">
                </div>
                <div class="three-image-side">
                  <div
                    v-for="(photo, index) in post.photos.slice(1)"
                    :key="photo.id"
                    class="three-image-item"
                    @click="openPhotoModal(photo)"
                  >
                    <img :src="photo.url" :alt="photo.caption" class="post-image">
                  </div>
                </div>
              </div>

              <div v-else class="multiple-images">
                <div
                  v-for="(photo, index) in post.photos.slice(0, 4)"
                  :key="photo.id"
                  class="multiple-image-item"
                  :class="{ 'last-image': index === 3 && post.photos.length > 4 }"
                  @click="openPhotoModal(photo)"
                >
                  <img :src="photo.url" :alt="photo.caption" class="post-image">
                  <div v-if="index === 3 && post.photos.length > 4" class="more-images-overlay">
                    <span>+{{ post.photos.length - 4 }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Post Tags -->
              <div v-if="post.tags && post.tags.length > 0" class="post-tags mt-2 flex flex-wrap gap-2">
              <span
                v-for="tag in post.tags"
                :key="tag.id"
                  class="tag cursor-pointer bg-primary-100 text-primary-700 px-2 py-1 rounded-full text-xs font-semibold hover:bg-primary-200 transition"
                  @click.stop="addTag(tag)"
              >
                #{{ tag.name }}
              </span>
            </div>

            <!-- Post Stats -->
            <div class="post-stats">
              <div class="stats-left">
                <span class="likes-count">{{ post.likes_count || 0 }} likes</span>
                <span class="comments-count">{{ post.comments_count || 0 }} comments</span>
              </div>
              <div class="stats-right">
                <span class="shares-count">0 shares</span>
              </div>
            </div>

            <!-- Post Actions -->
            <div class="post-actions">
              <button
                class="action-btn"
                :class="{ 'liked': post.is_liked }"
                @click="toggleLike(post)"
              >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
                <span>Like</span>
              </button>

              <button class="action-btn" @click="focusCommentInput(post)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>Comment</span>
              </button>

              <button class="action-btn" @click="sharePost(post)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                </svg>
                <span>Share</span>
              </button>
            </div>

            <!-- Comments Section -->
            <div class="comments-section">
              <div v-if="post.comments && post.comments.length > 0" class="comments-list">
                <div
                  v-for="comment in post.comments.slice(0, 3)"
                  :key="comment.id"
                  class="comment-item"
                >
                    <img :src="comment.user?.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=24&h=24&fit=crop&crop=face'" :alt="comment.user?.name" class="comment-avatar">
                  <div class="comment-content">
                    <div class="comment-bubble">
                      <span class="comment-author">{{ comment.user?.first_name }} {{ comment.user?.last_name }}</span>
                      <span class="comment-text">{{ comment.content }}</span>
                    </div>
                    <div class="comment-actions">
                      <button class="comment-action">Like</button>
                      <button class="comment-action">Reply</button>
                      <span class="comment-time">{{ formatDate(comment.created_at) }}</span>
                    </div>
                  </div>
                </div>

                <div v-if="post.comments.length > 3" class="view-more-comments">
                  <button @click="viewAllComments(post)">
                    View all {{ post.comments.length }} comments
                  </button>
                </div>
              </div>

              <!-- Add Comment -->
              <div class="add-comment">
                  <img :src="currentUser?.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=24&h=24&fit=crop&crop=face'" :alt="currentUser?.name" class="comment-avatar">
                <div class="comment-input-container">
                  <input
                    :ref="`commentInput-${post.id}`"
                    v-model="post.newComment"
                    type="text"
                    placeholder="Write a comment..."
                    class="comment-input"
                    @keyup.enter="addComment(post)"
                  >
                  <button
                    class="send-comment-btn"
                    @click="addComment(post)"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
          <div v-else-if="!loading && filteredPosts.length === 0" class="empty-state text-center py-16 text-secondary-500">
            <div class="text-5xl mb-2">🖼️</div>
            <div class="text-lg">No posts found for the selected tags.</div>
        </div>

          <!-- Loading Spinner -->
          <div v-if="loading && filteredPosts.length === 0" class="text-center py-16">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            <p class="mt-2 text-secondary-500">Loading posts...</p>
          </div>

          <!-- Error State -->
          <div v-if="error && filteredPosts.length === 0" class="error-state text-center py-16 text-secondary-500">
            <div class="text-5xl mb-2">⚠️</div>
            <div class="text-lg">Error loading posts</div>
            <p class="text-sm mt-1">{{ error }}</p>
            <button @click="reset" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
              Try Again
            </button>
          </div>

          <!-- Load More Loading -->
          <div v-if="loading && filteredPosts.length > 0" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary-600"></div>
            <p class="mt-2 text-sm text-secondary-500">Loading more posts...</p>
          </div>

          <!-- No More Posts -->
          <div v-if="!hasMore && filteredPosts.length > 0" class="text-center py-8 text-secondary-400">
            <p class="text-sm">No more posts to load</p>
          </div>
        </div>
      </div>

      <!-- Right: Chosen Tags & Post Details -->
      <div v-if="chosenTags.length > 0 || selectedPost" class="w-full lg:w-1/2 bg-white/90 border-l border-secondary-100 flex flex-col min-h-screen">
        <div class="p-6">
          <!-- Chosen Tags Card (desktop) -->
          <div v-if="chosenTags.length > 0" class="mb-6">
            <ChosenTagsCard :tags="chosenTags" @removeTag="removeTag" />
          </div>

          <!-- Post Details -->
          <div v-if="selectedPost">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-2xl font-bold text-primary-700">{{ selectedPost.title || 'Post Details' }}</h3>
              <button @click="closePost" class="text-secondary-500 hover:text-primary-600 text-2xl font-bold rounded-full p-2 transition"><span aria-label="Close">×</span></button>
            </div>
            <!-- Image Slider -->
            <div v-if="selectedPost.photos && selectedPost.photos.length > 0" class="mb-6">
              <div class="relative w-full h-72 bg-secondary-100 rounded-lg overflow-hidden flex items-center justify-center">
                <img
                  :src="selectedPost.photos[sliderIndex].url"
                  :alt="selectedPost.photos[sliderIndex].caption"
                  class="object-contain w-full h-full"
                />
                <button v-if="selectedPost.photos.length > 1" @click.stop="prevPhoto" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 rounded-full p-2 shadow hover:bg-primary-100 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></button>
                <button v-if="selectedPost.photos.length > 1" @click.stop="nextPhoto" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 rounded-full p-2 shadow hover:bg-primary-100 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></button>
              </div>
              <div class="flex justify-center gap-2 mt-2">
                <button
                  v-for="(photo, idx) in selectedPost.photos"
                  :key="photo.id"
                  class="w-3 h-3 rounded-full"
                  :class="sliderIndex === idx ? 'bg-primary-600' : 'bg-secondary-300'"
                  @click="sliderIndex = idx"
                ></button>
              </div>
            </div>
            <!-- Photo Description, Comments, Likes, Buttons -->
            <div class="mb-4">
              <h4 class="text-lg font-semibold mb-1">{{ selectedPost.photos[sliderIndex]?.caption || 'No description' }}</h4>
              <div class="flex items-center gap-4 text-secondary-500 text-sm mb-2">
                <span>❤️ {{ selectedPost.likes_count || 0 }}</span>
                <span>💬 {{ selectedPost.comments_count || 0 }}</span>
              </div>
              <div class="flex gap-2 mb-2">
                <button class="px-4 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-semibold hover:bg-primary-200 transition">Like</button>
                <button class="px-4 py-1 bg-secondary-100 text-secondary-700 rounded-full text-xs font-semibold hover:bg-secondary-200 transition">Comment</button>
              </div>
            </div>
            <!-- Comments List -->
            <div v-if="selectedPost.comments && selectedPost.comments.length > 0" class="mb-4">
              <div class="font-semibold text-secondary-700 mb-2">Comments</div>
              <div class="space-y-2 max-h-40 overflow-y-auto">
                <div v-for="comment in selectedPost.comments" :key="comment.id" class="bg-secondary-50 rounded p-2">
                                     <div class="flex items-center gap-2 mb-1">
                     <img :src="comment.user?.avatar || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=24&h=24&fit=crop&crop=face'" :alt="comment.user?.name" class="w-6 h-6 rounded-full">
                     <span class="font-bold text-secondary-900 text-xs">{{ comment.user?.first_name }} {{ comment.user?.last_name }}</span>
                     <span class="text-xs text-secondary-400 ml-auto">{{ formatDate(comment.created_at) }}</span>
                   </div>
                  <div class="text-secondary-700 text-sm">{{ comment.content }}</div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-secondary-400 text-center py-16">Select a post to view details.</div>
        </div>
      </div>

      <!-- Photo Modal -->
      <div v-if="selectedPhoto" class="photo-modal" @click="closePhotoModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <button class="close-btn" @click="closePhotoModal">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <div class="modal-body">
            <div class="photo-container">
              <img :src="selectedPhoto.url" :alt="selectedPhoto.caption" class="modal-photo">
            </div>

            <div class="photo-details">
              <div class="photo-info">
                <h3 class="photo-title">{{ selectedPhoto.caption || 'Untitled' }}</h3>
                <p class="photo-description">{{ selectedPhoto.description || '' }}</p>
                </div>
              </div>
                </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { useInfiniteScroll } from '../composables/useInfiniteScroll';
import { useAuth } from '../composables/useAuth';
import ChosenTagsCard from '../components/ChosenTagsCard.vue';

// Get page props
const page = usePage();
const { user: currentUser } = useAuth();

// Initialize infinite scroll for posts
const { items: posts, loading, hasMore, error, reset } = useInfiniteScroll({
    url: '/api/gallery/posts',
    perPage: 3,
    threshold: 200,
    onError: (err) => {
        console.error('Error loading posts:', err);
    }
});

const chosenTags = ref([]);
const selectedPost = ref(null);
const sliderIndex = ref(0);
const selectedPhoto = ref(null);

const filteredPosts = computed(() => {
  if (chosenTags.value.length === 0) return posts.value;
  // Only show posts that have ALL chosen tags
  return posts.value.filter(post =>
    chosenTags.value.every(tag => post.tags && post.tags.some(t => t.id === tag.id))
  );
});

function addTag(tag) {
  if (!chosenTags.value.some(t => t.id === tag.id)) {
    chosenTags.value.push(tag);
  }
}
function removeTag(tag) {
  chosenTags.value = chosenTags.value.filter(t => t.id !== tag.id);
}
function selectPost(post) {
  selectedPost.value = post;
  sliderIndex.value = 0;
}
function closePost() {
  selectedPost.value = null;
  sliderIndex.value = 0;
}
function prevPhoto() {
  if (!selectedPost.value) return;
  sliderIndex.value = (sliderIndex.value - 1 + selectedPost.value.photos.length) % selectedPost.value.photos.length;
}
function nextPhoto() {
  if (!selectedPost.value) return;
  sliderIndex.value = (sliderIndex.value + 1) % selectedPost.value.photos.length;
}
function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date.toLocaleDateString();
}

function openPhotoModal(photo) {
  selectedPhoto.value = photo;
}

function closePhotoModal() {
  selectedPhoto.value = null;
}

const toggleLike = (post) => {
  post.is_liked = !post.is_liked;
  post.likes_count += post.is_liked ? 1 : -1;

  // Make API call to update like status
  router.post(`/api/posts/${post.id}/like`, {}, {
    preserveState: true,
    preserveScroll: true
  });
};

const focusCommentInput = (post) => {
  // Focus the comment input for this post
  setTimeout(() => {
    const input = document.querySelector(`[ref="commentInput-${post.id}"]`);
    if (input) input.focus();
  }, 100);
};

const addComment = (post) => {
  if (!post.newComment.trim()) return;

  // Make API call to add comment
  router.post(`/api/posts/${post.id}/comments`, {
    content: post.newComment
  }, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      post.newComment = '';
    }
  });
};

const sharePost = (post) => {
  // Implement share functionality
  if (navigator.share) {
    navigator.share({
      title: post.caption || 'Check out this post',
      url: window.location.href
    });
  } else {
    // Fallback: copy to clipboard
    navigator.clipboard.writeText(window.location.href);
  }
};

const viewAllComments = (post) => {
  // Implement view all comments functionality
  console.log('View all comments for post:', post.id);
};
</script>

<style scoped>
.gallery-page {
  background: #f7f6fa;
  min-height: 100vh;
}
.gallery-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 2rem 1rem;
}
.gallery-header {
  text-align: center;
  margin-bottom: 2rem;
}
.gallery-title {
  font-size: 2.5rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 0.5rem;
}
.gallery-subtitle {
  font-size: 1.1rem;
  color: #6b7280;
  max-width: 600px;
  margin: 0 auto;
}
.posts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 2rem;
}
.post-card {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  transition: box-shadow 0.2s;
}
.post-card:hover {
  box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}
.post-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}
.author-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 0.75rem;
}
.author-info {
  display: flex;
  flex-direction: column;
}
.author-name {
  font-weight: 600;
  color: #1f2937;
  font-size: 1rem;
}
.post-time {
  font-size: 0.85rem;
  color: #6b7280;
}
.post-caption {
  color: #374151;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}
.post-images {
  margin-bottom: 0.5rem;
}
.post-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 0.75rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.post-tags {
  margin-top: 0.5rem;
}
.tag {
  margin-right: 0.5rem;
  background: #f3f4f6;
  color: #2563eb;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.tag:hover {
  background: #dbeafe;
  color: #1d4ed8;
}
.post-stats {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  border-top: 1px solid #f3f4f6;
  font-size: 0.875rem;
  color: #6b7280;
}

.stats-left {
  display: flex;
  gap: 1rem;
}

/* Post Actions */
.post-actions {
  display: flex;
  border-top: 1px solid #f3f4f6;
}

.action-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem;
  background: none;
  border: none;
  color: #6b7280;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

.action-btn:hover {
  background: #f9fafb;
}

.action-btn.liked {
  color: #ef4444;
}

/* Comments Section */
.comments-section {
  border-top: 1px solid #f3f4f6;
}

.comments-list {
  padding: 0.75rem 1rem;
}

.comment-item {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
}

.comment-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}

.comment-content {
  flex: 1;
}

.comment-bubble {
  background: #f3f4f6;
  padding: 0.5rem 0.75rem;
  border-radius: 1rem;
  display: inline-block;
  max-width: 100%;
}

.comment-author {
  font-weight: 600;
  color: #1f2937;
  font-size: 0.875rem;
  margin-right: 0.5rem;
}

.comment-text {
  color: #374151;
  font-size: 0.875rem;
}

.comment-actions {
  margin-top: 0.25rem;
  display: flex;
  gap: 0.75rem;
  font-size: 0.75rem;
}

.comment-action {
  background: none;
  border: none;
  color: #6b7280;
  cursor: pointer;
  font-weight: 500;
}

.comment-action:hover {
  text-decoration: underline;
}

.comment-time {
  color: #9ca3af;
}

.view-more-comments {
  padding: 0.5rem 0;
}

.view-more-comments button {
  background: none;
  border: none;
  color: #6b7280;
  cursor: pointer;
  font-size: 0.875rem;
}

.view-more-comments button:hover {
  text-decoration: underline;
}

/* Add Comment */
.add-comment {
  display: flex;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border-top: 1px solid #f3f4f6;
}

.comment-input-container {
  flex: 1;
  display: flex;
  align-items: center;
  background: #f9fafb;
  border-radius: 1.5rem;
  padding: 0.5rem 0.75rem;
}

.comment-input {
  flex: 1;
  background: none;
  border: none;
  outline: none;
  font-size: 0.875rem;
  color: #374151;
}

.comment-input::placeholder {
  color: #9ca3af;
}

.send-comment-btn {
  background: none;
  border: none;
  color: #3b82f6;
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 0.25rem;
}

.send-comment-btn:hover {
  background: #eff6ff;
}

/* Post Images */
.post-images {
  width: 100%;
}

.single-image {
  cursor: pointer;
}

.single-image img {
  width: 100%;
  height: auto;
  max-height: 600px;
  object-fit: cover;
}

.two-images {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2px;
}

.two-image-item {
  cursor: pointer;
}

.two-image-item img {
  width: 100%;
  height: 300px;
  object-fit: cover;
}

.three-images {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 2px;
  height: 400px;
}

.three-image-main {
  cursor: pointer;
}

.three-image-main img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.three-image-side {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.three-image-item {
  cursor: pointer;
  flex: 1;
}

.three-image-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.multiple-images {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  gap: 2px;
  height: 400px;
}

.multiple-image-item {
  cursor: pointer;
  position: relative;
}

.multiple-image-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.more-images-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
  font-weight: bold;
}

/* Photo Modal */
.photo-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 2rem;
}

.modal-content {
  background: white;
  border-radius: 0.75rem;
  max-width: 90vw;
  max-height: 90vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: flex-end;
  padding: 1rem;
  border-bottom: 1px solid #e5e7eb;
}

.close-btn {
  background: none;
  border: none;
  color: #6b7280;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 0.25rem;
}

.close-btn:hover {
  background: #f3f4f6;
}

.modal-body {
  display: flex;
  max-height: calc(90vh - 80px);
}

.photo-container {
  flex: 1;
  max-width: 60%;
}

.modal-photo {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.photo-details {
  flex: 1;
  max-width: 40%;
  padding: 1.5rem;
  overflow-y: auto;
  border-left: 1px solid #e5e7eb;
}

.photo-title {
  font-size: 1.25rem;
  font-weight: bold;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.photo-description {
  color: #6b7280;
  margin-bottom: 1rem;
  line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
  .modal-body {
    flex-direction: column;
  }

  .photo-container,
  .photo-details {
    max-width: 100%;
  }

  .photo-container {
    max-height: 50vh;
  }

  .three-images {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr 1fr;
    height: auto;
  }

  .multiple-images {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    height: 300px;
  }
}
</style>
