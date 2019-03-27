<template>
    <div>
        <div class="form-group">
            <label class="col-sm-2 col-form-label">Ответы</label>
            <div class="col-sm-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-content no-borders">
                        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addOption">Добавить</a>
                        <ul class="options-list m-t small-list">
                            <poll-options-list-item
                                v-for="option in options"
                                :key="option.model.id"
                                v-bind:option="option"
                                v-on:remove="removeOption"
                            />
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>
    </div>
</template>

<script>
    export default {
        name: 'PollOptionsList',
        props: {
            optionsProp: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        data() {
            return {
                options: this.prepareOptions()
            };
        },
        computed: {
            mode() {
                return window.Admin.vue.stores['pollOptions'].state.mode;
            }
        },
        watch: {
            mode: function (newMode) {
                if (newMode === 'save_list_item') {
                    this.saveOption();
                }
            },
            optionsProp: function () {
                this.options = this.prepareOptions();
            },
        },
        methods: {
            prepareOptions() {
                let options = [];

                this.optionsProp.forEach(function (element) {
                    options.push({
                        isModified: false,
                        model: element,
                        hash: window.hash(element)
                    });
                });

                return options;
            },
            addOption() {
                window.Admin.vue.stores['pollOptions'].commit('setMode', 'add_list_item');
                window.Admin.vue.stores['pollOptions'].commit('setOption', {});
                
                $('#options_list_item_form_modal').modal();
            },
            removeOption(payload) {
                let component = this;

                swal({
                    title: "Вы уверены?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Отмена",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да, удалить"
                }).then((result) => {
                    if (result.value) {
                        this.options = _.remove(this.options, function(option) {
                            return option.model.id !== payload.id;
                        });

                        component.$emit('update:options', {
                            options: _.map(this.options, 'model')
                        });
                    }
                });
            },
            saveOption() {
                let component = this;

                let storeOption = JSON.parse(JSON.stringify(window.Admin.vue.stores['pollOptions'].state.option));
                storeOption.hash = window.hash(storeOption.model);

                let index = this.getOptionIndex(storeOption.model.id);

                if (index > -1) {
                    this.$set(this.options, index, storeOption);
                } else {
                    this.options.push(storeOption);
                }

                component.$emit('update:options', {
                    options: _.map(this.options, 'model')
                });
            },
            getOptionIndex(id) {
                return _.findIndex(this.options, function (option) {
                    return option.model.id === id;
                });
            }
        }
    }
</script>

<style scoped>
</style>
