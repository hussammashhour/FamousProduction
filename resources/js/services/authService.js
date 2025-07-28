import axios from 'axios';

class AuthService {
    constructor() {
        this.tokenKey = 'auth_token';
        this.userKey = 'auth_user';
        this.setupAxiosInterceptors();
    }

    // Token Management
    setToken(token) {
        localStorage.setItem(this.tokenKey, token);
        this.setupAxiosInterceptors();
    }

    getToken() {
        return localStorage.getItem(this.tokenKey);
    }

    removeToken() {
        localStorage.removeItem(this.tokenKey);
        localStorage.removeItem(this.userKey);
        this.setupAxiosInterceptors();
    }

    // User Management
    setUser(user) {
        localStorage.setItem(this.userKey, JSON.stringify(user));
    }

    getUser() {
        const user = localStorage.getItem(this.userKey);
        return user ? JSON.parse(user) : null;
    }

    // Authentication Methods
    async login(credentials) {
        try {
            const response = await axios.post('/api/login', credentials);
            const { token, user } = response.data.data;

            this.setToken(token);
            this.setUser(user);

            return { success: true, user };
        } catch (error) {
            console.error('Login error:', error);
            return {
                success: false,
                error: error.response?.data?.message || 'Login failed'
            };
        }
    }

    async register(userData) {
        try {
            const response = await axios.post('/api/register', userData);
            const { token, user } = response.data.data;

            this.setToken(token);
            this.setUser(user);

            return { success: true, user };
        } catch (error) {
            console.error('Registration error:', error);
            return {
                success: false,
                error: error.response?.data?.message || 'Registration failed'
            };
        }
    }

    async logout() {
        try {
            if (this.getToken()) {
                await axios.post('/api/logout', {}, {
                    headers: { Authorization: `Bearer ${this.getToken()}` }
                });
            }
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            this.removeToken();
        }
    }

    async refreshToken() {
        try {
            const response = await axios.post('/api/refresh', {}, {
                headers: { Authorization: `Bearer ${this.getToken()}` }
            });

            const { token, user } = response.data.data;
            this.setToken(token);
            this.setUser(user);

            return { success: true, token };
        } catch (error) {
            console.error('Token refresh error:', error);
            this.removeToken();
            return { success: false, error: 'Token refresh failed' };
        }
    }

    // Check if user is authenticated
    isAuthenticated() {
        return !!this.getToken();
    }

    // Setup axios interceptors for automatic token handling
    setupAxiosInterceptors() {
        // Request interceptor to add token
        axios.interceptors.request.use(
            (config) => {
                const token = this.getToken();
                if (token) {
                    config.headers.Authorization = `Bearer ${token}`;
                }
                return config;
            },
            (error) => {
                return Promise.reject(error);
            }
        );

        // Response interceptor to handle token expiration
        axios.interceptors.response.use(
            (response) => response,
            async (error) => {
                const originalRequest = error.config;

                // If error is 401 and we haven't already tried to refresh
                if (error.response?.status === 401 && !originalRequest._retry) {
                    originalRequest._retry = true;

                    try {
                        const refreshResult = await this.refreshToken();
                        if (refreshResult.success) {
                            // Retry the original request with new token
                            originalRequest.headers.Authorization = `Bearer ${this.getToken()}`;
                            return axios(originalRequest);
                        } else {
                            // Refresh failed, redirect to login
                            this.handleAuthError();
                            return Promise.reject(error);
                        }
                    } catch (refreshError) {
                        this.handleAuthError();
                        return Promise.reject(error);
                    }
                }

                return Promise.reject(error);
            }
        );
    }

    // Handle authentication errors (redirect to login)
    handleAuthError() {
        this.removeToken();

        // If using Inertia.js, redirect to login
        if (window.Inertia) {
            window.Inertia.visit('/login');
        } else {
            // Fallback for non-Inertia apps
            window.location.href = '/login';
        }
    }

    // Get user roles
    getUserRoles() {
        const user = this.getUser();
        return user?.roles?.map(role => role.name) || [];
    }

    // Check if user has specific role
    hasRole(roleName) {
        return this.getUserRoles().includes(roleName);
    }

    // Check if user has any of the specified roles
    hasAnyRole(roleNames) {
        return this.getUserRoles().some(role => roleNames.includes(role));
    }
}

// Create singleton instance
const authService = new AuthService();

export default authService;
