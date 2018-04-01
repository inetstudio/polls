$(document).ready(function () {
    if ($('.editable-list').length > 0) {
        var editItemComponent = new Vue({
            el: '#edit_list_item_modal',
            data: {
                mode: '',
                target: '',
                item: {},
                inputs: []
            },
            methods: {
                save: function () {
                    var item = this.item;

                    $(this.$el).find('input').each(function () {
                        item.properties[$(this).attr('name')] = $(this).val();
                    });

                    if (this.mode === 'add') {
                        window.window.Admin.containers.lists[this.target].items.push(item);
                    }

                    $('#edit_list_item_modal').modal('hide');
                }
            }
        });

        $('.editable-list').each(function() {
            var name = $(this).attr('id'),
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

                        var properties = {};
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
        var url = $(this).attr('data-target');

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'html',
            success: function (data) {
                $('#poll_result_modal .modal-body').html(data);

                $('#poll_result_modal').modal();
            }
        });
    });
});
