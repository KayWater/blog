/*
|-------------------------------------------------------------------------------
| VUEX modules/cafes.js
|-------------------------------------------------------------------------------
| The Vuex data store for the cafes
*/

// status = 0 -> 数据尚未加载
// status = 1 -> 数据开始加载
// status = 2 -> 数据加载成功
// status = 3 -> 数据加载失败

import CafeApi from '../api/cafe.js';

export const cafes = {
    state: {
        cafes: [],
        cafesLoadStatus: 0,
        cafe: {},
        cafeLoadStatus: 0,

        cafeAddStatus: 0
    },

    actions: {
        loadCafes({commit}) {
            commit('setCafesLoadStatus', 1);
            CafeApi.getCafes()
                .then(function(response){
                    commit('setCafes', response.date);
                    commit('setCafesLoadStatus', 2);
                })
                .catch(function(){
                    commit('setCafes', []);
                    commit('setCafesLoadStatus', 3);
                });
        },
        loadCafe({commit}, data) {
            commit('setCafeLoadStatus', 1);
            CafeApi.getCafe()
                .then(function(response){
                    commit('setCafe', response.data);
                    commit('setCafeLoadStatus', 2);
                }).catch(function(){
                    commit('setCafe', {});
                    commit('setCafeLoadStatus', 3);
                });
        },

        addCafe({commit, state, dispatch}, data) {
            commit('setCafeAddStatus', 1);

            CafeApi.postAddNewCafe(data.name, data.address, data.city, data.state, data.zip)
                    .then(function(response) {
                        commit('setCafeAddStatus', 2);
                        dispatch('loadCafes');
                    }).catch(function(){
                        commit('setCafeAddStatus', 3);
                    });
        }
    },

    mutations: {
        setCafesLoadStatus(state, status) {
            state.cafesLoadStatus = status;
        },
        
        setCafes(state, cafes) {
            state.cafes = cafes;
        },

        setCafeLoadStatus(state, status) {
            state.cafeLoadStatus = status;
        },

        setCafe(state, cafe) {
            state.cafe = cafe;
        },

        setCafeAddStatus(state, status) {
            state.cafeAddStatus = status;
        }
    },

    getters: {
        getCafesLoadStatus(state) {
            return state.cafesLoadStatus;
        },

        getCafes(state) {
            return state.cafes;
        },

        getCafeLoadStatus(state) {
            return state.cafeLoadStatus;
        },

        getCafe(state) {
            return state.cafe;
        },

        getCafeAddStatus(state) {
            return status.cafeAddStatus;
        }
    }

}