import Vue from 'vue'
import Vuex from 'vuex'

/**
 * Adds the promise polyfill for IE 11
 */
require('es6-promise').polyfill();

Vue.use(Vuex)

import { users } from './modules/user.js';
import { auth } from './modules/auth.js';

export default new Vuex.Store({
    modules: {
        users,
        auth,
    }
})