import { CONFIG } from '../config.js';

export default {
    /**
     * Add a new post
     * Method:      POST
     * API:         /api/v1/post
     */
    addPost: function(post) {
        return axios.post( CONFIG.API_URL + '/post', {
            draftID: post.draftID,
            postID: post.postID,
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
        return axios.put( CONFIG.API_URL + '/post/' + post.postID, {
            draftID: post.draftID,
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
     * Get post
     * Method:      GET
     * API:         /api/v1/post/:id
     */
    getPost: function(id) {
        return axios.get( CONFIG.API_URL + '/post/' + id );
    },

    deletePost: function(id) {
        return axios.delete( CONFIG.API_URL + '/posts/' + id );
    },

    /**
     * Auto save
     * Method:      POST
     * API:         /api/v1/autosave
     */
    autosave: function(post) {
        return axios.post( CONFIG.API_URL + '/post/autosave', {
            draftID: post.draftID,
            postID: post.postID,
            title: post.title,
            content: post.content,
            tags: post.tags,
        })
    },

    /**
     * Delete a draft
     * Method:      DELETE
     * API:         /api/v1/draft/:draftID
     */
    deleteDraft: function(draftID) {
        return axios.delete( CONFIG.API_URL + '/draft/' + draftID );
    },
}