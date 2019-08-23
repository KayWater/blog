import BrewMethodAPI from '../api/brewMethod.js';

export const brewMethods = {
    state: {
        brewMethods: [],
        brewMethodsLoadStatus: 0
    },

    actions: {
        loadBrewMethods({commit}) {
            commit('setBrewMethodsLoadStatus', 1);

            BrewMethodAPI.getBrewMethods()
                .then(function(response) {
                    commit('setBrewMethods', reponse.data);
                    commit('setBrewMethodsLoadStatus', 2);
                }).catch(function(){
                    commit('setBrewMethods', []);
                    commit('setBrewMethodsLoadStatus', 3);
                })
        }
    },

    mutations: {
        setBrewMethodsLoadStatus(state, status) {
            state.setBrewMethodsLoadStatus = status;
        },

        setBrewMethods(state, brewMethods) {
            state.setBrewMethods = brewMethods;
        },
    },

    getters: {
        getBrewMethods(state) {
            return state.brewMethods;
        },

        getBrewMethodsLoadStatus(state) {
            return state.brewMethodsLoadStatus;
        }
    }

}