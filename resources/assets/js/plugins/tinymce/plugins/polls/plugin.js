let addPollModal = $('#add_poll_modal'),
    pollModal = $('#poll_modal'),
    pollWidgetID = '';

addPollModal.find('.create-poll').on('click', function (event) {
    event.preventDefault();

    $('#add_poll_modal').modal('hide');
    $('#poll_modal').modal();
});

addPollModal.find('.save').on('click', function (event) {
    event.preventDefault();

    let option = addPollModal.find('option:selected'),
        editor = $(this).attr('data-editor'),
        title = option.text(),
        id = option.val();

    if (id !== '') {
        window.Admin.modules.widgets.saveWidget(pollWidgetID, {
            view: 'admin.module.polls::front.partials.content.poll_widget',
            params: {
                id: id
            }
        }, {
            editor: window.tinymce.get(editor),
            type: 'poll',
            alt: 'Виджет-опрос: '+title
        });
    }

    $('#add_poll_modal').modal('hide');
});

pollModal.find('.save').on('click', function (event) {
    event.preventDefault();

    let form = pollModal.find('form'),
        editor = $(this).attr('data-editor'),
        data = form.serialize();

    $.ajax({
        'url': form.attr('action'),
        'type': form.attr('method'),
        'data': data,
        'dataType': 'json',
        'success': function (data) {
            if (data.success === true) {
                $('#poll_modal').modal('hide');

                window.Admin.modules.widgets.saveWidget(pollWidgetID, {
                    view: 'admin.module.polls::front.partials.content.poll_widget',
                    params: {
                        id: data.id
                    }
                }, {
                    editor: window.tinymce.get(editor),
                    type: 'poll',
                    alt: 'Виджет-опрос: '+data.title
                });

                if (pollModal.find('input[name=poll_id]').val() !== '') {
                    swal({
                        title: "Опрос отредактирован",
                        type: "success"
                    });
                } else {
                    swal({
                        title: "Опрос создан",
                        type: "success"
                    });
                }
            }
        },
        'error': function () {
            swal({
                title: "Ошибка",
                text: "При создании опроса произошла ошибка",
                type: "error"
            });
        }
    });
});

window.tinymce.PluginManager.add('polls', function (editor) {
    editor.addButton('add_poll_widget', {
        title: 'Опросы',
        icon: 'question',
        onclick: function() {
            addPollModal.find('.save').attr('data-editor', editor.id);
            pollModal.find('.save').attr('data-editor', editor.id);

            let content = window.tinymce.get(editor.id).selection.getContent();

            if (content !== '' && ! /<img class="content-widget".+data-type="poll".+\/>/g.test(content)) {
                swal({
                    title: "Ошибка",
                    text: "Необходимо выбрать виджет-опрос",
                    type: "error"
                });

                return false;
            } else if (content !== '') {
                pollWidgetID = $(content).attr('data-id');

                window.Admin.modules.widgets.getWidget(pollWidgetID, function (widget) {
                    let pollID = widget.params.id;

                    $.ajax({
                        url: route('back.polls.show', pollID),
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success === true) {
                                pollModal.find('.modal-header h1').text('Редактирование опроса');
                                pollModal.find('form').attr('action', route('back.polls.update', data.id));
                                pollModal.find('input[name=_method]').val('PUT');
                                pollModal.find('input[name=poll_id]').val(data.id);
                                pollModal.find('input[name=question]').val(data.question);
                                window.Admin.containers.lists['options_field_block'].items = data.options;
                                pollModal.find('.save').attr('data-editor', editor.id);

                                $('#poll_modal').modal();
                            }
                        },
                        error: function () {
                            swal({
                                title: "Ошибка",
                                text: "При получении опроса произошла ошибка",
                                type: "error"
                            });
                        }
                    });
                });
            } else {
                pollWidgetID = '';

                $('#add_poll_modal').modal();
            }
        }
    })
});
