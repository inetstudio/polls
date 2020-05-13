let polls = {};

polls.init = function() {
  $(document).ready(function() {
    if ($('#pollForm').length > 0) {
      let formApp = new Vue({
        el: '#pollForm',
      });

      window.Admin.vue.helpers.initComponent('polls', 'PollOptionsListItemForm', {});
    }
  });
};

module.exports = polls;
