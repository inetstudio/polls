import {polls} from './package/polls';

require('./plugins/tinymce/plugins/polls');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

require('./stores/polls');

window.Vue.component(
    'PollWidget',
    () => import('./components/partials/PollWidget/PollWidget.vue'),
);
window.Vue.component(
    'PollModalForm',
    () => import('./components/partials/PollModalForm/PollModalForm.vue'),
);

polls.init();
