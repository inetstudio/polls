<template>
    <div id="add_poll_widget_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Опросы</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-autocomplete
                            label = "Опросы"
                            name = "poll"
                            v-bind:value="poll.question"
                            v-bind:attributes = "{
                                'data-search': suggestionsUrl,
                                'placeholder': 'Выберите опрос',
                                'autocomplete': 'off'
                            }"
                            v-on:select="suggestionSelect"
                        />
                        <p class="text-right"><a href="#" class="btn btn-xs btn-primary" v-on:click.prevent="createPoll">Создать новый</a></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PollWidget",
        data() {
            return {
                model: this.getDefaultModel(),
                poll: {
                    question: '',
                },
                options: {
                    loading: true
                },
                events: {
                    widgetLoaded: function (component) {
                        let url = route('back.polls.show', component.model.params.id).toString();

                        component.options.loading = true;

                        axios.get(url).then(response => {
                            component.poll.question = response.data.question;
                            component.options.loading = false;
                        });
                    }
                }
            };
        },
        computed: {
            suggestionsUrl() {
                return route('back.polls.getSuggestions').toString();
            },
            modalPollState() {
                return window.Admin.vue.stores['polls'].state.mode;
            }
        },
        watch: {
            modalPollState: function (newMode) {
                if (newMode === 'poll_created') {
                    let poll = window.Admin.vue.stores['polls'].state.poll;

                    this.model.params.id = poll.model.id;
                    this.poll.question = poll.model.question;

                    this.save();
                }
            }
        },
        methods: {
            getDefaultModel() {
                return _.merge(this.getDefaultWidgetModel(), {
                    view: 'admin.module.polls::front.partials.content.poll_widget',
                    params: {
                        id: 0
                    }
                });
            },
            initComponent() {
                let component = this;

                component.model = _.merge(component.model, this.widget.model);
                component.options.loading = false;
            },
            suggestionSelect(payload) {
                let component = this;

                let data = payload.data;

                component.model.params.id = data.id;
                component.poll.question = data.name;
            },
            save() {
                let component = this;

                if (component.model.params.id === 0) {
                    $(component.$refs.modal).modal('hide');

                    return;
                }

                component.saveWidget(function () {
                    $(component.$refs.modal).modal('hide');
                });
            },
            createPoll() {
                window.Admin.vue.stores['polls'].commit('setMode', 'create_item');
                window.Admin.vue.stores['polls'].commit('setPoll', {});

                window.waitForElement('#poll_modal', function() {
                    $('#poll_modal').modal();
                });
            }
        },
        created: function () {
            this.initComponent();
        },
        mounted() {
            let component = this;

            this.$nextTick(function() {
                $(component.$refs.modal).on('hide.bs.modal', function() {
                    component.poll.question = '';
                    component.model = component.getDefaultModel();
                });
            });
        },
        mixins: [
            window.Admin.vue.mixins['widget']
        ]
    }
</script>

<style scoped>
</style>
