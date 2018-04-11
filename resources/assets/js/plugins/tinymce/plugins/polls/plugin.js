let addPollModal = $('#add_poll_modal'),
    pollModal = $('#poll_modal');

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
        window.tinymce.get(editor).editorManager.execCommand('mceInsertContent', false, '<img class="content-widget" data-type="poll" data-id="'+id+'" alt="Виджет-опрос: '+title+'" style="height: 100px; width: 100%; border: 1px red solid;" />');
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

                if (pollModal.find('input[name=poll_id]').val() !== '') {
                    swal({
                        title: "Опрос отредактирован",
                        type: "success"
                    });

                    window.tinymce.get(editor).selection.setContent('<img class="content-widget" data-type="poll" data-id="'+data.id+'" alt="Виджет-опрос: '+data.title+'" style="height: 100px; width: 100%; border: 1px red solid;" />')
                } else {
                    swal({
                        title: "Опрос создан",
                        type: "success"
                    });

                    window.tinymce.get(editor).editorManager.execCommand('mceInsertContent', false, '<img class="content-widget" data-type="poll" data-id="'+data.id+'" alt="Виджет-опрос: '+data.title+'" style="height: 100px; width: 100%; border: 1px red solid;" />');
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
    editor.addButton('polls', {
        title: 'Опросы',
        image: '/admin/images/tinymce-button-polls.png',
        onclick: function() {
            let content = window.tinymce.get(editor.id).selection.getContent();

            if (content !== '' && ! /<img class="content-widget".+data-type="poll".+\/>/g.test(content)) {
                swal({
                    title: "Ошибка",
                    text: "Необходимо выбрать виджет-опрос",
                    type: "error"
                });

                return false;
            } else if (content !== '') {
                let pollID = $(content).attr('data-id');

                $.ajax({
                    url: '/back/polls/info',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: pollID
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success === true) {
                            pollModal.find('.modal-header h1').text('Редактирование опроса');
                            pollModal.find('form').attr('action', '/back/polls/' + data.id);
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
            } else {
                pollModal.find('.modal-header h1').text('Создание опроса');
                pollModal.find('form').attr('action', '/back/polls/');
                pollModal.find('input[name=_method]').val('POST');
                pollModal.find('input[name=poll_id]').val('');
                pollModal.find('input[name=question]').val('');
                window.Admin.containers.lists['options_field_block'].items = [];
                pollModal.find('.save').attr('data-editor', editor.id);

                addPollModal.find('.save').attr('data-editor', editor.id);
                addPollModal.find('select.select2').val('');
                addPollModal.find('select.select2').trigger('change');
                $('#add_poll_modal').modal();
            }
        }
    })
});
