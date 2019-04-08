require('./plugins/tinymce/plugins/polls');

require('../../../../../../widgets/resources/assets/js/mixins/widget');

require('./stores/polls');

Vue.component(
    'PollWidget',
    require('./components/partials/PollWidget/PollWidget.vue').default,
);
Vue.component(
    'PollModalForm',
    require('./components/partials/PollModalForm/PollModalForm.vue').default,
);

let polls = require('./package/polls');
polls.init();
