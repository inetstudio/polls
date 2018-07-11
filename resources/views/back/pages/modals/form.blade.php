@pushonce('modals:poll')
    <div id="add_poll_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Добавление опроса</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content form-horizontal">
                        <div class="row">
                            {!! Form::dropdown('poll', [], [
                                'label' => [
                                    'title' => 'Опросы',
                                ],
                                'field' => [
                                    'class' => 'select2 form-control',
                                    'data-placeholder' => 'Выберите опрос',
                                    'style' => 'width: 100%',
                                ],
                                'options' => [
                                    'values' => [null => ''] + \InetStudio\Polls\Models\PollModel::select('id', 'question as name')->pluck('name', 'id')->toArray(),
                                ],
                            ]) !!}
                            <p class="text-right"><a href="#" class="btn btn-xs btn-primary create-poll">создать новый</a></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>

    <div id="poll_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Создание опроса</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content form-horizontal">
                        <div class="row">
                            {!! Form::open(['url' => '', 'id' => 'pollModalForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

                                {{ method_field('') }}

                                {!! Form::hidden('poll_id', '') !!}

                                {!! Form::string('question', '', [
                                    'label' => [
                                        'title' => 'Вопрос',
                                    ],
                                ]) !!}

                                {!! Form::list('options', [], [
                                    'label' => [
                                        'title' => 'Варианты ответа',
                                    ],
                                    'fields' => [
                                        [
                                            'title' => 'Ответ',
                                            'name' => 'answer',
                                        ],
                                    ],
                                ]) !!}

                            {!! Form::close()!!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
@endpushonce
