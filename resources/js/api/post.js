import { CONFIG } from '../config.js';

export default {
    /**
     * Add a new post
     * Method:      POST
     * API:         /api/v1/post
     */
    addPost: function(post) {
        return axios.post( CONFIG.API_URL + '/post', {
            title: post.title,
            tags: post.tags,
            content: post.content,
        } );
    },

    /**
     * Update a post
     * Method:      PUT
     * API:         /api/v1/post/:postID
     */
    updatePost: function(post) {
        return axios.put( CONFIG.API_URL + '/post/' + post.id, {
            title: post.title,
            tags: post.tags,
            content: post.content,
        } );
    },

    /**
     * Get posts (pagination)
     * Method:      GET
     * API:         /api/v1/posts
     */
    getPosts: function(params) {
        return axios.get( CONFIG.API_URL + '/posts', params );
    },

    /**
     * Delete a post
     * Method:      DELETE
     * API:         /api/v1/post
     */
    deletePost: function(postID) {
        return axios.delete( CONFIG.API_URL + '/post/' + postID );
    },

}