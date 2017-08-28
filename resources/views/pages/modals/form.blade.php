<!-- CUSTOM STYLE -->
<link href="{!! asset('admin/css/modules/polls/custom.css') !!}" rel="stylesheet">

<div class="modal inmodal fade" id="modal_poll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
            </div>
            <div class="modal-body">
                <div class="ibox-content form-horizontal">
                    <div class="row">
                        {!! Form::open(['url' => (!$item->id) ? route('back.polls.store') : route('back.polls.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

                            @if ($item->id)
                                {{ method_field('PUT') }}
                            @endif

                            {!! Form::hidden('poll_id', (!$item->id) ? '' : $item->id) !!}

                            {!! Form::string('question', $item->question, [
                                'label' => [
                                    'title' => 'Вопрос',
                                ],
                            ]) !!}

                            {!! Form::list('option', [], [
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
                <a href="#" class="btn btn-primary" @click.prevent="save">Сохранить</a>
            </div>
        </div>
    </div>
</div>
