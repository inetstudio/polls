require('./stores/pollOptions');

window.Vue.component(
    'PollOptionsList',
    () => import('./components/partials/PollOptionsList/PollOptionsList.vue'),
);

window.Vue.component(
    'PollOptionsListItem',
    () => import('./components/partials/PollOptionsList/PollOptionsListItem.vue')
);

window.Vue.component(
    'PollOptionsListItemForm',
    () => import('./components/partials/PollOptionsList/PollOptionsListItemForm.vue')
);
