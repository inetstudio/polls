import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['polls'] = new window.Vuex.Store({
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
      emptyPoll.model.id = uuidv4();

      let resultPoll = _.merge(emptyPoll, poll);
      resultPoll.hash = hash(resultPoll.model);

      state.poll = resultPoll;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
  },
});
