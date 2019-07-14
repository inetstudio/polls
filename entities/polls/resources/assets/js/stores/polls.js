window.Admin.vue.stores['polls'] = new Vuex.Store({
  state: {
    emptyPoll: {
      model: {
        question: '',
        options: [],
        single: ['1'],
        closed: [],
        created_at: null,
        updated_at: null,
        deleted_at: null,
      },
      isModified: false,
      hash: '',
    },
    poll: {},
    mode: '',
  },
  mutations: {
    setPoll(state, poll) {
      let emptyPoll = JSON.parse(JSON.stringify(state.emptyPoll));
      emptyPoll.model.id = UUID.generate();

      let resultPoll = _.merge(emptyPoll, poll);
      resultPoll.hash = window.hash(resultPoll.model);

      state.poll = resultPoll;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
  },
});
