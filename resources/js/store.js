import Vue from 'vue'
import Vuex from 'vuex'

/**
 * Adds the promise polyfill for IE 11
 */
require('es6-promise').polyfill();

Vue.use(Vuex)

import {cafes} from './modules/cafes.js'
import {brewMethods} from './modules/brewMethod.js';


export default new Vuex.Store({
    modules: {
        cafes,
        brewMethods
    }
})