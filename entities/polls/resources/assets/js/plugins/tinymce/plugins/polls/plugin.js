import Swal from 'sweetalert2';

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

  function loadWidget() {
    let component = window.Admin.vue.helpers.getVueComponent('polls', 'PollWidget');

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

        window.Admin.vue.helpers.initComponent('polls', 'PollWidget', widgetData);
        window.Admin.vue.helpers.initComponent('polls', 'PollModalForm', {});
        window.Admin.vue.helpers.initComponent('polls', 'PollOptionsListItemForm', {});

        window.waitForElement('#add_poll_widget_modal', function() {
          loadWidget();

          $('#add_poll_widget_modal').modal();
        });
      } else {
        Swal.fire({
          title: 'Ошибка',
          text: 'Необходимо выбрать виджет-опрос',
          icon: 'error',
        });

        return false;
      }
    },
  });
});
