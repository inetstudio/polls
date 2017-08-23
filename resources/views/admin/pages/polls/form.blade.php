@php
    $title = ($item->id) ? 'Редактирование опроса' : 'Добавление опроса';
@endphp

@extends('admin::layouts.app')

@section('title', $title)

@section('styles')
    <!-- CUSTOM STYLE -->
    <link href="{!! asset('admin/css/modules/polls/custom.css') !!}" rel="stylesheet">
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>
                {{ $title }}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/back/') }}">Главная</a>
                </li>
                <li>
                    <a href="{{ route('back.polls.index') }}">Опросы</a>
                </li>
                <li class="active">
                    <strong>
                        {{ $title }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (!$item->id) ? route('back.polls.store') : route('back.polls.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('poll_id', (!$item->id) ? '' : $item->id) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::string('question', $item->question, [
                                        'label' => [
                                            'title' => 'Вопрос',
                                        ],
                                    ]) !!}

                                    {!! Form::list('options', collect($item->options), [
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

                                    {!! Form::checks('single', $item->single, [
                                        'label' => [
                                            'title' => 'Одиночный выбор',
                                        ],
                                        'checks' => [
                                            [
                                                'value' => 1,
                                            ],
                                        ],
                                    ]) !!}

                                    {!! Form::checks('closed', $item->closed, [
                                        'label' => [
                                            'title' => 'Закрыть опрос',
                                        ],
                                        'checks' => [
                                            [
                                                'value' => 1,
                                            ],
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::buttons('', '', ['back' => 'back.polls.index']) !!}

        {!! Form::close()!!}
    </div>

    {!! Form::modals_list() !!}

@endsection
