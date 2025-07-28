# Infinite Scroll Gallery Implementation

This guide explains how the infinite scroll pagination works in the gallery page.

## Overview

The gallery page now implements infinite scroll pagination that loads posts 3 by 3 when the user reaches the end of the page. This provides a smooth, seamless browsing experience without traditional pagination controls.

## How It Works

### 1. Backend API Endpoint

**Route**: `GET /api/gallery/posts`

**Controller**: `GalleryController@getPosts`

**Parameters**:
- `page` (optional): Page number (default: 1)
- `per_page` (optional): Posts per page (default: 3)

**Response**:
```json
{
  "success": true,
  "data": {
    "posts": [...],
    "pagination": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 3,
      "total": 15,
      "has_more_pages": true
    }
  },
  "message": "Posts retrieved successfully."
}
```

### 2. Frontend Implementation

#### Infinite Scroll Composable

The `useInfiniteScroll` composable handles:
- Automatic scroll detection
- API calls with pagination
- Loading states
- Error handling
- Throttled scroll events for performance

```javascript
const { items: posts, loading, hasMore, error, reset } = useInfiniteScroll({
    url: '/api/gallery/posts',
    perPage: 3,
    threshold: 200, // pixels from bottom to trigger load
    onError: (err) => {
        console.error('Error loading posts:', err);
    }
});
```

#### Scroll Detection

The system monitors scroll position and automatically loads more posts when the user is within 200 pixels of the bottom of the page.

### 3. User Experience Features

#### Loading States
- **Initial Loading**: Shows spinner when first loading posts
- **Load More Loading**: Shows "Loading more posts..." when fetching additional pages
- **No More Posts**: Shows completion message when all posts are loaded

#### Error Handling
- **Network Errors**: Shows error message with retry button
- **API Errors**: Displays specific error messages from the server
- **Retry Functionality**: Users can retry failed requests

#### Performance Optimizations
- **Throttled Scroll Events**: Prevents excessive API calls
- **Efficient DOM Updates**: Only adds new posts to the list
- **Memory Management**: Proper cleanup of event listeners

## Implementation Details

### 1. Backend Components

#### GalleryController.php
```php
public function getPosts(Request $request)
{
    $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);
    $query->withCount(['likes', 'comments']);
    
    $page = $request->get('page', 1);
    $perPage = $request->get('per_page', 3);
    
    $posts = $query->latest()->paginate($perPage, ['*'], 'page', $page);
    
    // Add is_liked property for authenticated users
    if (Auth::check()) {
        $posts->getCollection()->transform(function ($post) {
            $post->is_liked = $post->likes->contains('user_id', Auth::id());
            return $post;
        });
    }
    
    return $this->successResponse([
        'posts' => PostResource::collection($posts),
        'pagination' => [
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'has_more_pages' => $posts->hasMorePages(),
        ]
    ], 'Posts retrieved successfully.');
}
```

### 2. Frontend Components

#### useInfiniteScroll.js
```javascript
export function useInfiniteScroll(options = {}) {
    const {
        url = '',
        pageParam = 'page',
        perPage = 3,
        threshold = 100,
        enabled = true,
        onLoad = null,
        onError = null,
        onComplete = null
    } = options;

    // Implementation details...
}
```

#### Gallery.vue
```vue
<template>
  <div class="gallery-page">
    <!-- Posts Grid -->
    <div v-if="posts && posts.length > 0" class="posts-grid">
      <!-- Post cards -->
    </div>

    <!-- Loading States -->
    <LoadingSpinner v-if="loading && posts.length === 0" />
    <LoadingSpinner v-if="loading && posts.length > 0" text="Loading more posts..." />
    
    <!-- Error State -->
    <div v-if="error && posts.length === 0" class="error-state">
      <!-- Error content -->
    </div>
    
    <!-- No More Posts -->
    <NoMorePosts v-if="!hasMore && posts.length > 0" />
  </div>
</template>
```

## Configuration Options

### 1. Posts Per Page
Change the number of posts loaded per request:
```javascript
const { items: posts } = useInfiniteScroll({
    url: '/api/gallery/posts',
    perPage: 5, // Load 5 posts instead of 3
});
```

### 2. Scroll Threshold
Adjust when new posts are loaded:
```javascript
const { items: posts } = useInfiniteScroll({
    url: '/api/gallery/posts',
    threshold: 500, // Load when 500px from bottom
});
```

### 3. Custom Callbacks
Add custom logic for different events:
```javascript
const { items: posts } = useInfiniteScroll({
    url: '/api/gallery/posts',
    onLoad: (newPosts, pagination) => {
        console.log(`Loaded ${newPosts.length} new posts`);
    },
    onError: (error) => {
        // Custom error handling
    },
    onComplete: () => {
        console.log('All posts loaded!');
    }
});
```

## Testing

### 1. Manual Testing
1. Navigate to the gallery page
2. Scroll down to trigger loading
3. Verify posts load 3 at a time
4. Check loading states appear correctly
5. Scroll to bottom to see "no more posts" message

### 2. API Testing
```bash
# Test first page
curl "http://localhost:8000/api/gallery/posts?page=1&per_page=3"

# Test second page
curl "http://localhost:8000/api/gallery/posts?page=2&per_page=3"
```

### 3. Error Testing
- Disconnect internet to test error handling
- Test with invalid page numbers
- Verify retry functionality works

## Performance Considerations

### 1. Database Optimization
- Posts are loaded with eager relationships to prevent N+1 queries
- Pagination uses efficient database queries
- Indexes on `created_at` for fast ordering

### 2. Frontend Optimization
- Scroll events are throttled to prevent excessive API calls
- Only new posts are added to the DOM
- Event listeners are properly cleaned up

### 3. Caching
- Consider implementing Redis caching for frequently accessed posts
- Cache pagination results to reduce database load

## Troubleshooting

### 1. Posts Not Loading
- Check browser console for errors
- Verify API endpoint is accessible
- Check network tab for failed requests

### 2. Infinite Loading
- Verify `has_more_pages` is correctly set in API response
- Check if pagination logic is working correctly

### 3. Performance Issues
- Reduce posts per page
- Increase scroll threshold
- Implement virtual scrolling for large datasets

## Future Enhancements

### 1. Virtual Scrolling
For very large datasets, consider implementing virtual scrolling to only render visible posts.

### 2. Preloading
Preload the next page of posts before the user reaches the bottom.

### 3. Search and Filtering
Add search and filtering capabilities while maintaining infinite scroll.

### 4. Real-time Updates
Implement WebSocket updates for new posts in real-time.

This infinite scroll implementation provides a modern, user-friendly browsing experience while maintaining good performance and error handling. 
