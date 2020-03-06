import { CONFIG } from '../config.js';

export default {
    /**
     * POST     /api/v1/auth/register
     */
    register: function(name, email, password) {
        return axios.post(CONFIG.API_URL + '/auth/register', {
            name: name,
            email: email,
            password: password,
        });
    },

    /**
     * POST     /api/v1/auth/login
     */
    login: function(email, password) {
        return axios.post(CONFIG.API_URL + '/auth/login', {
            email: email,
            password: password,
        });
    },

    /**
     * Post     /api/v1/auth/logout
     */
    logout: function() {
        return axios.post(CONFIG.API_URL + '/auth/logout');
    },
} 