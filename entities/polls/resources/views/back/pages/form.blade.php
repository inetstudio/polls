@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование опроса' : 'Создание опроса';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.polls::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content" id="pollForm">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.polls.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (!$item->id) ? route('back.polls.store') : route('back.polls.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item->id)
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('poll_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

        {!! Form::hidden('poll_type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.polls.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">Основная информация</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body polls-package">

                                        {!! Form::string('question', $item->question, [
                                            'label' => [
                                                'title' => 'Вопрос',
                                            ],
                                        ]) !!}

                                        <poll-options-list
                                                v-bind:options-prop="{{ json_encode($item->options->toArray()) }}"></poll-options-list>

                                        {!! Form::hidden('single', 0) !!}
                                        {!! Form::checks('single', ($item->id) ? $item->single : 1, [
                                            'label' => [
                                                'title' => 'Одиночный выбор',
                                            ],
                                            'checks' => [
                                                [
                                                    'value' => 1,
                                                ],
                                            ],
                                        ]) !!}

                                        {!! Form::hidden('closed', 0) !!}
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
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.polls.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
