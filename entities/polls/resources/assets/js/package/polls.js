let polls = {};

polls.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('polls')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          polls: {
            components: [],
          },
        });
  }

  $(document).ready(function() {
    if ($('#pollForm').length > 0) {
      let formApp = new Vue({
        el: '#pollForm',
      });

      if (typeof window.Admin.vue.modulesComponents.$refs['polls_PollOptionsListItemForm'] ==
          'undefined') {
        window.Admin.vue.modulesComponents.modules.polls.components = _.union(
            window.Admin.vue.modulesComponents.modules.polls.components, [
              {
                name: 'PollOptionsListItemForm',
                data: {},
              },
            ]);
      }
    }
  });
};

module.exports = polls;
