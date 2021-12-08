import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['pollOptions'] = new window.Vuex.Store({
  state: {
    emptyOption: {
      model: {
        answer: '',
        created_at: null,
        updated_at: null,
        deleted_at: null,
      },
      isModified: false,
      hash: '',
    },
    option: {},
    mode: '',
  },
  mutations: {
    setOption(state, option) {
      let emptyOption = JSON.parse(JSON.stringify(state.emptyOption));
      emptyOption.model.id = uuidv4();

      let resultOption = _.merge(emptyOption, option);
      resultOption.hash = hash(resultOption.model);

      state.option = resultOption;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
  },
});
