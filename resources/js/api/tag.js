import { CONFIG } from '../config.js';

export default {
    /**
     * Add a new tag
     * Method: post
     * Api:     /api/v1/tag
     */
    addTag: function(name) {
        return axios.post(CONFIG.API_URL + '/tag', {
            name: name,
        } );
    },
    /**
     * Get tags
     * Method:  get
     * Api:     /api/v1/tags
     */
    getTags: function(params) {
        return axios.get(CONFIG.API_URL + '/tags', params);
    },


}