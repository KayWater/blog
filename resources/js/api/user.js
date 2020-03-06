import { CONFIG } from '../config.js';

export default {
    /**
     * GET      /api/v1/me
     */
    getMe: function() {
        return axios.get(CONFIG.API_URL + '/me');
    },

    /**
     * GET      /api/v1/user
     */
    getUser: function() {
        return axios.get(CONFIG.API_URL + '/user');
    },

    /**
     * Get posts belongs to current user
     * Method:      GET
     * API:         /api/v1/user/posts
     */
    getPosts: function(params) {
        return axios.get( CONFIG.API_URL + '/user/posts', params);
    },

    /**
     * Get the post belongs to current user
     * Method:      GET
     * API:         /api/v1/user/post/:postID
     */
    getPost: function(postID) {
        return axios.get( CONFIG.API_URL + '/user/post/' + postID );
    },
}