export const auth = {
    /**
     * Defines the state being monitored for the module.
     */
    state: {
        dialogLoginVisible: false,
    },

    /**
     * Defines the actions used to retrieve the data.
     */
    actions: {
        
    },

    /**
     * Defines the mutations to update the state
     */
    mutations: {
        /**
         * set dialogLoginVisible state
         * @param {*} state 
         * @param {*} visible 
         */
        setDialogLoginVisible(state, visible) {
            state.dialogLoginVisible = visible;
        },
    },

    /**
     * Defines the getters to retrieve the state
     */
    getters: {
        
    }   
}