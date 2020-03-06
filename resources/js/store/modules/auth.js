import AuthAPI from '../../api/auth.js';

export const auth = {
    namespaced: true,

    /**
     * Defines the state being monitored for the module.
     */
    state: {
        /**
         * accessToken
         */
        accessToken: window.localStorage.getItem('access_token'),
    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        /**
         * Register action
         */
        register({commit}, data) {
            return new Promise((resolve, reject) => {
                AuthAPI.register(data.username, data.email, data.password)
                    .then((response) => {
                        commit('setAccessToken', response.data.access_token);
                        window.localStorage.setItem('access_token', response.data.access_token);
                        window.localStorage.setItem('expires_in', response.data.expires_in);
                        window.localStorage.setItem('refresh_token', response.data.refresh_token);
                        window.localStorage.setItem('token_type', response.data.token_type);
                        window.axios.defaults.headers.common['Authorization'] = response.data.token_type + " " + response.data.access_token;
                        resolve(response.data);
                    }).catch((error) => {
                        reject(error.response.data);
                    });
            });
        },

        /**
         * Login action
         */
        login({commit}, data) {
            return new Promise((resolve, reject) => {
                AuthAPI.login(data.email, data.password)
                    .then((response) => {
                        commit('setAccessToken', response.data.access_token);
                        window.localStorage.setItem('access_token', response.data.access_token);
                        window.localStorage.setItem('expires_in', response.data.expires_in);
                        window.localStorage.setItem('refresh_token', response.data.refresh_token);
                        window.localStorage.setItem('token_type', response.data.token_type);
                        window.axios.defaults.headers.common['Authorization'] = response.data.token_type + " " + response.data.access_token;
                        resolve(response.data);
                    }).catch((error) => {
                        reject(error.response.data);
                    })
            })
        },

        /**
         * logout action
         */
        logout({commit}) {
            return new Promise((resolve, reject) => {
                AuthAPI.logout()
                    .then((response) => {
                        window.localStorage.removeItem('access_token');
                        window.localStorage.removeItem('expires_in');
                        window.localStorage.removeItem('refresh_token');
                        window.localStorage.removeItem('token_type');
                        commit('setAccessToken', null);
                        resolve(response.data);
                    }).catch((error) => {
                        reject(error.response.data);
                    });
            });
        },
    },

    /**
     * Defines the mutations to update the state
     */
    mutations: {
        /**
         * Set accessToken
         */
        setAccessToken(state, token) {
            state.accessToken = token;
        }
    },

    /**
     * Defines the getters to retrieve the state
     */
    getters: {
        /**
         * Whether is logined
         */
        isLogined: (state) => {
            return !!state.accessToken;
        }
    }   
}