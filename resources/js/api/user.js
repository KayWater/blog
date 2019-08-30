import { CONFIG } from '../config.js';

export default {
    /**
     * GET      /api/v1/user
     */
    getUser: function() {
        return axios.get(CONFIG.API_URL + '/user');
    }
}