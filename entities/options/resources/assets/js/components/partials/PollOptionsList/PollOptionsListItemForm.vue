<template>
    <div class="modal inmodal fade" id="options_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true"
         ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 v-if="mode === 'add_list_item'" class="modal-title">Создание элемента</h1>
                    <h1 v-else class="modal-title">Редактирование элемента</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content">
                        <base-input-text
                              label="Ответ"
                              name="answer"
                              v-bind:value.sync="option.model.answer"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="saveOption">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'PollOptionsListItemForm',
    data() {
      return {
        option: {},
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['pollOptions'].state.mode;
      },
    },
    watch: {
      'option.model': {
        handler: function(newValue, oldValue) {
          this.option.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.option.hash === window.hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.option = JSON.parse(JSON.stringify(window.Admin.vue.stores['pollOptions'].state.emptyOption));
      },
      loadOption() {
        let component = this;

        component.option = JSON.parse(JSON.stringify(window.Admin.vue.stores['pollOptions'].state.option));
      },
      saveOption() {
        let component = this;

        if (component.option.isModified) {
          window.Admin.vue.stores['pollOptions'].commit('setOption', JSON.parse(JSON.stringify(component.option)));
          window.Admin.vue.stores['pollOptions'].commit('setMode', 'save_list_item');
        }

        $(this.$refs.modal).modal('hide');
      },
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadOption();
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.option = JSON.parse(JSON.stringify(window.Admin.vue.stores['pollOptions'].state.emptyOption));
        });
      });
    },
  };
</script>

<style scoped>
</style>
