window.tinymce.PluginManager.add('polls', function(editor) {
  let widgetData = {
    widget: {
      events: {
        widgetSaved: function(model) {
          editor.execCommand('mceReplaceContent', false,
              '<img class="content-widget" data-type="poll" data-id="' +
              model.id + '" alt="Виджет-опрос" />',
          );
        },
      },
    },
  };

  function initPollsComponents() {
    if (typeof window.Admin.vue.modulesComponents.$refs['polls_PollWidget'] ==
        'undefined') {
      window.Admin.vue.modulesComponents.modules.polls.components = _.union(
          window.Admin.vue.modulesComponents.modules.polls.components, [
            {
              name: 'PollWidget',
              data: widgetData,
            },
          ]);
      window.Admin.vue.modulesComponents.modules.polls.components = _.union(
          window.Admin.vue.modulesComponents.modules.polls.components, [
            {
              name: 'PollModalForm',
              data: {},
            },
          ]);
      window.Admin.vue.modulesComponents.modules.polls.components = _.union(
          window.Admin.vue.modulesComponents.modules.polls.components, [
            {
              name: 'PollOptionsListItemForm',
              data: {},
            },
          ]);
    }
  }

  function loadWidget() {
    let component = window.Admin.vue.modulesComponents.$refs['polls_PollWidget'][0];

    component.$data.model.id = widgetData.model.id;
  }

  editor.addButton('add_poll_widget', {
    title: 'Опросы',
    icon: 'fa fa-poll',
    onclick: function() {
      let content = editor.selection.getContent();

      let isPoll = /<img class="content-widget".+data-type="poll".+>/g.test(content);

      if (content === '' || isPoll) {
        widgetData.model = {
          id: parseInt($(content).attr('data-id')) || 0,
        };

        initPollsComponents('widget');

        window.waitForElement('#add_poll_widget_modal', function() {
          loadWidget();

          $('#add_poll_widget_modal').modal();
        });
      } else {
        swal({
          title: 'Ошибка',
          text: 'Необходимо выбрать виджет-опрос',
          type: 'error',
        });

        return false;
      }
    },
  });
});
