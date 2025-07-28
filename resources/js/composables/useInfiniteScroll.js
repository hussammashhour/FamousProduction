import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

export function useInfiniteScroll(options = {}) {
    const {
        url = '',
        pageParam = 'page',
        perPage = 3,
        threshold = 100, // pixels from bottom to trigger load
        enabled = true,
        onLoad = null,
        onError = null,
        onComplete = null
    } = options;

    const items = ref([]);
    const loading = ref(false);
    const hasMore = ref(true);
    const currentPage = ref(1);
    const error = ref(null);

    const loadMore = async () => {
        if (loading.value || !hasMore.value || !enabled) return;

        loading.value = true;
        error.value = null;

        try {
            const response = await axios.get(url, {
                params: {
                    [pageParam]: currentPage.value,
                    per_page: perPage
                }
            });

            const { posts, pagination } = response.data.data;

            // Add new items to the list
            items.value.push(...posts);

            // Update pagination state
            hasMore.value = pagination.has_more_pages;
            currentPage.value = pagination.current_page + 1;

            // Call onLoad callback if provided
            if (onLoad) {
                onLoad(posts, pagination);
            }

            // Call onComplete callback if no more pages
            if (!hasMore.value && onComplete) {
                onComplete();
            }

        } catch (err) {
            console.error('Error loading more items:', err);
            error.value = err.response?.data?.message || 'Failed to load more items';

            // Call onError callback if provided
            if (onError) {
                onError(err);
            }
        } finally {
            loading.value = false;
        }
    };

    const reset = () => {
        items.value = [];
        loading.value = false;
        hasMore.value = true;
        currentPage.value = 1;
        error.value = null;
    };

    const checkScroll = () => {
        if (!enabled || loading.value || !hasMore.value) return;

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;

        if (scrollTop + windowHeight >= documentHeight - threshold) {
            loadMore();
        }
    };

    const handleScroll = () => {
        // Throttle scroll events for better performance
        if (scrollTimeout.value) {
            clearTimeout(scrollTimeout.value);
        }

        scrollTimeout.value = setTimeout(checkScroll, 100);
    };

    const scrollTimeout = ref(null);

    onMounted(() => {
        if (enabled) {
            window.addEventListener('scroll', handleScroll);
            // Load initial data
            loadMore();
        }
    });

    onUnmounted(() => {
        if (enabled) {
            window.removeEventListener('scroll', handleScroll);
            if (scrollTimeout.value) {
                clearTimeout(scrollTimeout.value);
            }
        }
    });

    return {
        items,
        loading,
        hasMore,
        currentPage,
        error,
        loadMore,
        reset
    };
}
