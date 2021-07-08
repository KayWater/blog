import PostAPI from '../../api/post.js';

export const post = {
    namespaced: true,
    /**
     * Defines the state being monitored for the module.
     */
    state: {

    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        deletePost({commit}, id) {
            return new Promise((resolve, reject) => {
                PostAPI.deletePost(id)
                    .then((response) => {
                        resolve(response.data);
                    }).catch((error) => {
                        reject(error.response.data);
                    });
            });
        }
    },

    /**
     * Defines the mutations to update the state
     */
    mutations: {

    },

    /**
     * Defines the getters to retrieve the state
     */
    getters: {
        
    }   
}