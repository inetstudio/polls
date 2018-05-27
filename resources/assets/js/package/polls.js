let polls = {};

polls.init = function () {
    $(document).ready(function () {
        if ($('.editable-list').length > 0) {
            let editItemComponent = new Vue({
                el: '#edit_list_item_modal',
                data: {
                    mode: '',
                    target: '',
                    item: {},
                    inputs: []
                },
                methods: {
                    save: function () {
                        let item = this.item;

                        $(this.$el).find('input').each(function () {
                            item.properties[$(this).attr('name')] = $(this).val();
                        });

                        if (this.mode === 'add') {
                            window.Admin.containers.lists[this.target].items.push(item);
                        }

                        $('#edit_list_item_modal').modal('hide');
                    }
                }
            });

            $('.editable-list').each(function() {
                let name = $(this).attr('id'),
                    inputs = JSON.parse($(this).attr('data-properties')),
                    items = JSON.parse($(this).attr('data-items'));

                window.Admin.containers.lists[name] = new Vue({
                    el: '#'+name,
                    data: {
                        items: items,
                        inputs: inputs
                    },
                    methods: {
                        add: function (index) {
                            editItemComponent.mode = 'add';
                            editItemComponent.target = this.$el.id;
                            editItemComponent.inputs = this.inputs;

                            let properties = {};
                            $.each(this.inputs, function (key, value) {
                                properties[value.name] = "";
                            });

                            editItemComponent.item = {
                                properties: properties
                            };

                            $('#edit_list_item_modal').modal();
                        },
                        edit: function (index) {
                            editItemComponent.item = {};

                            editItemComponent.mode = 'edit';
                            editItemComponent.target = this.$el.id;
                            editItemComponent.inputs = this.inputs;
                            editItemComponent.item = this.items[index];

                            $('#edit_list_item_modal').modal();
                        },
                        remove: function (index) {
                            this.$delete(this.items, index);
                        }
                    },
                    computed: {
                        itemTitles: function() {
                            return this.items.map(function(item) {
                                return item.properties[Object.keys(item.properties)[0]];
                            });
                        }
                    }
                });
            });
        }

        $('.polls-analytics').on('click', '.show-result', function () {
            let url = $(this).attr('data-target');

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('#poll_result_modal .modal-body').html(data);

                    $('#poll_result_modal').modal();
                }
            });
        });
    });
    
    $('#poll_modal').on('hidden.bs.modal', function (e) {
        let modal = $(this);

        modal.find('.modal-header h1').text('Создание опроса');
        modal.find('form').attr('action', route('back.polls.store'));
        modal.find('input[name=_method]').val('POST');
        modal.find('input[name=poll_id]').val('');
        modal.find('input[name=question]').val('');
        modal.find('.save').attr('data-editor', '');

        window.Admin.containers.lists['options_field_block'].items = [];
    });

    $('#add_poll_modal').on('hidden.bs.modal', function (e) {
        let modal = $(this);

        modal.find('.save').attr('data-editor', '');
        modal.find('select.select2').val('');
        modal.find('select.select2').trigger('change');
    })
};

module.exports = polls;
