import { ref, computed, readonly } from 'vue';
import authService from '../services/authService';

export function useAuth() {
    const user = ref(authService.getUser());
    const isAuthenticated = ref(authService.isAuthenticated());

    // Reactive computed properties
    const userRoles = computed(() => {
        return user.value?.roles?.map(role => role.name) || [];
    });

    const hasRole = (roleName) => {
        return userRoles.value.includes(roleName);
    };

    const hasAnyRole = (roleNames) => {
        return userRoles.value.some(role => roleNames.includes(role));
    };

    // Authentication methods
    const login = async (credentials) => {
        const result = await authService.login(credentials);
        if (result.success) {
            user.value = result.user;
            isAuthenticated.value = true;
        }
        return result;
    };

    const register = async (userData) => {
        const result = await authService.register(userData);
        if (result.success) {
            user.value = result.user;
            isAuthenticated.value = true;
        }
        return result;
    };

    const logout = async () => {
        await authService.logout();
        user.value = null;
        isAuthenticated.value = false;
    };

    const refreshToken = async () => {
        const result = await authService.refreshToken();
        if (result.success) {
            user.value = authService.getUser();
            isAuthenticated.value = true;
        }
        return result;
    };

    // Check authentication status
    const checkAuth = () => {
        const currentUser = authService.getUser();
        const currentAuth = authService.isAuthenticated();

        user.value = currentUser;
        isAuthenticated.value = currentAuth;

        return currentAuth;
    };

    return {
        // State
        user: readonly(user),
        isAuthenticated: readonly(isAuthenticated),
        userRoles: readonly(userRoles),

        // Methods
        login,
        register,
        logout,
        refreshToken,
        checkAuth,
        hasRole,
        hasAnyRole,
    };
}
