import UserAPI from '../../api/user.js';

export const user = {
    namespaced: true,
    /**
     * Defines the state being monitored for the module.
     */
    state: {
        /**
         * User 
         */
        user: null,

        /**
         * Current user
         */
        me: null,

    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        /**
         * Load Current user
         */
        loadMe({commit}) {
            return new Promise((resolve, reject) => {
                UserAPI.getMe()
                .then((response) => {
                    commit('setMe', response.data.user);
                    resolve(response.data);
                }).catch((error) => {
                    commit('setMe', null);
                    reject(error.response.data);
                });
            });
        },

        /**
         * Load User
         */
        loadUser({commit}) {
            return new Promise((resolve, reject) => {
                UserAPI.getUser()
                    .then((response) => {
                        commit('setUser', response.data);
                    }).catch((error) => {
                        commit('setUser', null);
                    })
            })
        },

        loadPosts({commit}, params) {
            return new Promise((resolve, reject) => {
                UserAPI.loadPosts(params)
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
        /**
         * Set current user 
         */
        setMe(state, user) {
            state.me = user;
        },

        /**
         * Set the user 
         */
        setUser(state, user) {
            state.user = user;
        },

    },

    /**
     * Defines the getters to retrieve the state
     */
    getters: {
        
    }   
}