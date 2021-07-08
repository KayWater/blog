import Vue from 'vue'
import Vuex from 'vuex'

/**
 * Adds the promise polyfill for IE 11
 */
require('es6-promise').polyfill();

Vue.use(Vuex)

import { user } from './modules/user.js';
import { auth } from './modules/auth.js';
import { post } from './modules/post.js';

export default new Vuex.Store({
    modules: {
        user,
        auth,
        post
    }
})