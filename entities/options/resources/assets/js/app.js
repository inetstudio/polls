require('./stores/pollOptions');

Vue.component(
    'PollOptionsList',
    require('./components/partials/PollOptionsList/PollOptionsList.vue').default,
);
Vue.component(
    'PollOptionsListItem', require(
        './components/partials/PollOptionsList/PollOptionsListItem.vue').default);
Vue.component(
    'PollOptionsListItemForm', require(
        './components/partials/PollOptionsList/PollOptionsListItemForm.vue').default);
