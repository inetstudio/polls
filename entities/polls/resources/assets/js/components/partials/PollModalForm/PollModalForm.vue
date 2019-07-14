<template>
    <div id="poll_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Создание опроса</h1>
                </div>

                <div class="modal-body polls-package">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-input-text
                            label="Вопрос"
                            name="poll_question"
                            v-bind:value.sync="poll.model.question"
                        />

                        <poll-options-list
                            v-bind:options-prop="poll.model.options"
                            v-on:update:options="updateOptions"
                        />

                        <base-checkboxes
                            label="Одиночный выбор"
                            name="poll_single"
                            v-bind:checkboxes="[
                                {
                                    value: '1',
                                    label: ''
                                }
                            ]"
                            v-bind:selected.sync="poll.model.single"
                        />

                        <base-checkboxes
                            label="Закрыть опрос"
                            name="poll_closed"
                            v-bind:checkboxes="[
                                {
                                    value: '1',
                                    label: ''
                                }
                            ]"
                            v-bind:selected.sync="poll.model.closed"
                        />

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save" v-on:click.prevent="savePoll">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'PollModalForm',
    props: {
      form: {
        type: Object,
        default() {
          return {
            events: {
              pollSaved: function() {},
            },
          };
        },
      },
    },
    data() {
      return {
        poll: {},
        options: {
          loading: true,
        },
        events: this.form.events,
      };
    },
    watch: {
      'poll.model': {
        handler: function(newValue, oldValue) {
          this.poll.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.poll.hash === window.hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.poll = JSON.parse(JSON.stringify(window.Admin.vue.stores['polls'].state.emptyPoll));

        component.options.loading = false;
      },
      loadPoll() {
        let component = this;

        this.options.loading = true;
        component.poll = JSON.parse(JSON.stringify(window.Admin.vue.stores['polls'].state.poll));

        if (typeof component.poll.model.id === 'string') {
          this.options.loading = false;

          return;
        }

        let url = route('back.polls.show', component.poll.model.id);

        axios.get(url).then(response => {
          component.poll = {
            errors: {},
            isModified: false,
            model: response.data,
            hash: window.hash(response.data),
          };

          this.options.loading = false;
        });
      },
      savePoll() {
        let component = this;

        if (component.poll.isModified && component.poll.model.question !== '') {
          component.options.loading = true;

          let url = (typeof component.poll.model.id !== 'string')
              ? route('back.polls.update', component.poll.model.id)
              : route('back.polls.store');

          let data = JSON.parse(JSON.stringify(component.poll.model));
          if (typeof component.poll.model.id !== 'string') {
            data._method = 'PUT';
          }

          axios.post(url, data).then(response => {
            component.poll = {
              errors: {},
              isModified: false,
              model: response.data,
            };

            component.pollSaved(component.poll);
          });
        } else {
          $(this.$refs.modal).modal('hide');
        }
      },
      pollSaved(poll) {
        let component = this;

        component.events.pollSaved(poll);
        component.options.loading = false;

        window.Admin.vue.stores['polls'].commit('setPoll', JSON.parse(JSON.stringify(component.poll)));
        window.Admin.vue.stores['polls'].commit('setMode', 'poll_created');

        $(component.$refs.modal).modal('hide');
      },
      updateOptions(payload) {
        this.poll.model.options = payload.options;
      },
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      $(component.$refs.modal).on('show.bs.modal', function() {
        component.loadPoll();
      });

      this.$nextTick(function() {
        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.poll = JSON.parse(JSON.stringify(window.Admin.vue.stores['polls'].state.emptyPoll));
        });
      });
    },
  };
</script>

<style scoped>
</style>
