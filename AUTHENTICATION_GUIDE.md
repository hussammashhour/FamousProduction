# Authentication System Guide

This guide explains how to manage sessions and tokens in your Laravel application for both web and API authentication.

## Overview

Your application uses a hybrid authentication system:
- **Web Authentication**: Session-based for the frontend (Inertia.js)
- **API Authentication**: Sanctum tokens for API endpoints

## Backend Setup

### 1. API Authentication Endpoints

The following endpoints are available for API authentication:

```php
// Authentication routes (routes/api.php)
POST /api/login          // Login and get token
POST /api/register       // Register and get token
GET  /api/me            // Get current user (authenticated)
POST /api/logout        // Logout and revoke token
POST /api/logout-all    // Revoke all tokens
POST /api/refresh       // Refresh token
```

### 2. Using API Endpoints

#### Login
```javascript
// Frontend login
const response = await axios.post('/api/login', {
    email: 'user@example.com',
    password: 'password',
    device_name: 'iPhone' // Optional
});

const { token, user } = response.data.data;
```

#### Making Authenticated Requests
```javascript
// Token is automatically added to requests via axios interceptor
const response = await axios.get('/api/posts');
const response = await axios.post('/api/posts/1/like');
const response = await axios.post('/api/posts/1/comments', {
    content: 'Great post!'
});
```

### 3. Protected API Routes

All API routes that require authentication use the `auth:sanctum` middleware:

```php
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/posts/{post}/like', [PostController::class, 'like']);
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);
    // ... other protected routes
});
```

## Frontend Setup

### 1. Authentication Service

The `authService.js` handles all token management:

```javascript
import authService from '../services/authService';

// Login
const result = await authService.login({
    email: 'user@example.com',
    password: 'password',
    device_name: 'Desktop'
});

// Check if authenticated
if (authService.isAuthenticated()) {
    // User is logged in
}

// Get current user
const user = authService.getUser();

// Logout
await authService.logout();
```

### 2. Vue.js Composable

Use the `useAuth` composable for reactive authentication state:

```javascript
import { useAuth } from '../composables/useAuth';

const { user, isAuthenticated, login, logout, hasRole } = useAuth();

// Check authentication
if (isAuthenticated.value) {
    console.log('User is logged in:', user.value);
}

// Check roles
if (hasRole('admin')) {
    console.log('User is admin');
}
```

### 3. Automatic Token Management

The authentication service automatically:
- Adds the Bearer token to all axios requests
- Handles token expiration by attempting to refresh
- Redirects to login page when authentication fails
- Stores tokens in localStorage

## Usage Examples

### 1. Like a Post

```javascript
// The token is automatically included in the request
const response = await axios.post(`/api/posts/${postId}/like`);
```

### 2. Add a Comment

```javascript
const response = await axios.post(`/api/posts/${postId}/comments`, {
    content: 'This is a great post!'
});
```

### 3. Check Authentication Before Action

```javascript
import { useAuth } from '../composables/useAuth';

const { isAuthenticated } = useAuth();

const handleLike = async () => {
    if (!isAuthenticated.value) {
        // Show login modal or redirect
        window.location.href = '/login';
        return;
    }
    
    // Proceed with like action
    await axios.post(`/api/posts/${postId}/like`);
};
```

### 4. Role-Based Access Control

```javascript
import { useAuth } from '../composables/useAuth';

const { hasRole, hasAnyRole } = useAuth();

// Check specific role
if (hasRole('admin')) {
    // Show admin features
}

// Check multiple roles
if (hasAnyRole(['admin', 'moderator'])) {
    // Show moderator features
}
```

## Error Handling

### 1. Authentication Errors

When a token expires or is invalid:
1. The system automatically tries to refresh the token
2. If refresh fails, the user is redirected to login
3. The original request is retried with the new token

### 2. Manual Error Handling

```javascript
try {
    const response = await axios.post('/api/posts/1/like');
} catch (error) {
    if (error.response?.status === 401) {
        // User needs to log in
        window.location.href = '/login';
    } else {
        // Handle other errors
        console.error('Error:', error);
    }
}
```

## Security Features

### 1. Token Management
- Tokens are stored securely in localStorage
- Automatic token refresh on expiration
- Ability to revoke all tokens (logout-all)
- Device-specific token naming

### 2. CSRF Protection
- Web routes use Laravel's built-in CSRF protection
- API routes use Sanctum's token-based authentication

### 3. Rate Limiting
- Login attempts are rate-limited
- API endpoints can have custom rate limits

## Configuration

### 1. Sanctum Configuration

Edit `config/sanctum.php` to customize:
- Token expiration time
- Stateful domains
- Token prefix

### 2. Session Configuration

Edit `config/session.php` to customize:
- Session lifetime
- Session driver (database recommended)
- Cookie settings

## Testing

### 1. API Testing

```php
// In your tests
$user = User::factory()->create();
$token = $user->createToken('test-token')->plainTextToken;

$response = $this->withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->post('/api/posts/1/like');

$response->assertStatus(200);
```

### 2. Frontend Testing

```javascript
// Mock authentication service
jest.mock('../services/authService', () => ({
    isAuthenticated: () => true,
    getUser: () => ({ id: 1, name: 'Test User' }),
    getToken: () => 'test-token'
}));
```

## Troubleshooting

### 1. Token Not Being Sent
- Check if the token is stored in localStorage
- Verify axios interceptors are set up
- Check browser console for errors

### 2. 401 Unauthorized Errors
- Token may be expired - check if refresh is working
- User may not be authenticated
- Check if the route requires authentication

### 3. CORS Issues
- Ensure Sanctum stateful domains are configured
- Check if the frontend domain is in the allowed list

### 4. Session Issues
- Verify session configuration
- Check if session driver is working (database/file)
- Clear browser cookies and localStorage

## Best Practices

1. **Always check authentication before making API calls**
2. **Use the composable for reactive state management**
3. **Handle errors gracefully with user-friendly messages**
4. **Implement proper logout functionality**
5. **Use role-based access control for sensitive operations**
6. **Regularly rotate tokens for security**
7. **Monitor failed authentication attempts**
8. **Use HTTPS in production**

## Migration from Web Sessions to API Tokens

If you're migrating from web sessions to API tokens:

1. Update frontend components to use the authentication service
2. Replace session-based checks with token-based checks
3. Update axios configuration to include tokens
4. Test all authenticated endpoints
5. Update error handling for 401 responses

This authentication system provides a robust, secure, and user-friendly way to handle both web and API authentication in your Laravel application. 
