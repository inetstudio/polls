window.Admin.vue.stores['pollOptions'] = new Vuex.Store({
    state: {
        emptyOption: {
            model: {
                answer: '',
                created_at: null,
                updated_at: null,
                deleted_at: null
            },
            isModified: false,
            hash: ''
        },
        option: {},
        mode: ''
    },
    mutations: {
        setOption (state, option) {
            let emptyOption = JSON.parse(JSON.stringify(state.emptyOption));
            emptyOption.model.id = UUID.generate();

            let resultOption = _.merge(emptyOption, option);
            resultOption.hash = window.hash(resultOption.model);

            state.option = resultOption;
        },
        setMode (state, mode) {
            state.mode = mode;
        },
    }
});
