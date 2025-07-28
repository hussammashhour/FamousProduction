import axios from 'axios';
import authService from './services/authService';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Initialize authentication service
window.authService = authService;
