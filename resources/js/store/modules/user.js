import UserAPI from '../../api/user.js';

export const users = {
    /**
     * Defines the state being monitored for the module.
     */
    state: {
        user: {},
        userLoadStatus: 0,
        userUpdateStatus: 0,
        isLogined: false,
    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        loadUser({commit}) {
            commit('setUserLoadStatus', 1);

            UserAPI.getUser()
                .then(function(response) {
                    commit('setUser', response.data);
                    commit('setUserLoadStatus', 2);
                }).catch(function() {
                    commit('setUser', {});
                    commit('setUserLoadStatus', 3);
                })
        }
    },

    /**
     * Defines the mutations to update the state
     */
    mutations: {
        /**
         * Set the user 
         */
        setUser(state, user) {
            state.user = user;
        },

        /**
         * Set user load status
         */
        setUserLoadStatus(state, status) {
            state.userLoadStatus = status;
        },

        /**
         * Set user update status
         */
        setUserUpdateStatus(state, status) {
            state.userUpdateStatus = status;
        }
    },

    /**
     * Defines the getters to retrieve the state
     */
    getters: {
        
    }   
}