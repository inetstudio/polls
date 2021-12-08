let polls = {};

polls.init = function() {
  $(document).ready(function() {
    if ($('#pollForm').length > 0) {
      let formApp = new window.Vue({
        el: '#pollForm',
      });

      window.Admin.vue.helpers.initComponent('polls', 'PollOptionsListItemForm', {});
    }
  });
};

module.exports = polls;
