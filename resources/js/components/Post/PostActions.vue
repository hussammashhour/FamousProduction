<template>
    <div class="post-actions">
        <!-- Like Button -->
        <button
            @click="handleLike"
            :disabled="loading"
            class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-colors"
            :class="isLiked ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
        >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path v-if="isLiked" d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                <path v-else d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
            </svg>
            <span>{{ likesCount }}</span>
        </button>

        <!-- Comment Button -->
        <button
            @click="showCommentForm = !showCommentForm"
            class="flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span>{{ commentsCount }}</span>
        </button>
    </div>

    <!-- Comment Form -->
    <div v-if="showCommentForm" class="mt-4">
        <form @submit.prevent="handleComment" class="space-y-4">
            <textarea
                v-model="commentText"
                placeholder="Write a comment..."
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                rows="3"
                required
            ></textarea>

            <div class="flex justify-end space-x-2">
                <button
                    type="button"
                    @click="showCommentForm = false"
                    class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    :disabled="commentLoading"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-50 transition-colors"
                >
                    {{ commentLoading ? 'Posting...' : 'Post Comment' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Error Message -->
    <div v-if="error" class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ error }}
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuth } from '../../composables/useAuth';
import axios from 'axios';

const props = defineProps({
    postId: {
        type: Number,
        required: true
    },
    initialLikesCount: {
        type: Number,
        default: 0
    },
    initialCommentsCount: {
        type: Number,
        default: 0
    },
    initialIsLiked: {
        type: Boolean,
        default: false
    }
});

const { isAuthenticated, user } = useAuth();

const loading = ref(false);
const commentLoading = ref(false);
const error = ref('');
const showCommentForm = ref(false);
const commentText = ref('');

const likesCount = ref(props.initialLikesCount);
const commentsCount = ref(props.initialCommentsCount);
const isLiked = ref(props.initialIsLiked);

const handleLike = async () => {
    if (!isAuthenticated.value) {
        error.value = 'Please log in to like posts';
        return;
    }

    loading.value = true;
    error.value = '';

    try {
        const response = await axios.post(`/api/posts/${props.postId}/like`);

        // Update like status based on response
        isLiked.value = !isLiked.value;
        likesCount.value += isLiked.value ? 1 : -1;

    } catch (err) {
        console.error('Like error:', err);
        if (err.response?.status === 401) {
            error.value = 'Please log in to like posts';
        } else {
            error.value = 'Failed to like post. Please try again.';
        }
    } finally {
        loading.value = false;
    }
};

const handleComment = async () => {
    if (!isAuthenticated.value) {
        error.value = 'Please log in to comment';
        return;
    }

    if (!commentText.value.trim()) {
        error.value = 'Please enter a comment';
        return;
    }

    commentLoading.value = true;
    error.value = '';

    try {
        const response = await axios.post(`/api/posts/${props.postId}/comments`, {
            content: commentText.value
        });

        // Clear form and update count
        commentText.value = '';
        showCommentForm.value = false;
        commentsCount.value += 1;

        // Emit event to parent component to refresh comments
        emit('comment-added', response.data.data);

    } catch (err) {
        console.error('Comment error:', err);
        if (err.response?.status === 401) {
            error.value = 'Please log in to comment';
        } else {
            error.value = 'Failed to post comment. Please try again.';
        }
    } finally {
        commentLoading.value = false;
    }
};

const emit = defineEmits(['comment-added']);
</script>
