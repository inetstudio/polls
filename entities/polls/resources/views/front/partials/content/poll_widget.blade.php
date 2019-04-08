@inject('pollsService', 'InetStudio\PollsPackage\Polls\Contracts\Services\Front\PollsServiceContract')

@php
    $poll = $pollsService->getItemById($id, [
        'relations' => ['options'],
    ]);
    $result = $pollsService->isVote($id);
@endphp

@if (isset($poll))
    <div class="article-block_poll pink-bg" data-result="{{ route('front.widget.get', ['id' => $widget->id]) }}">
        <p class="article-block_poll-is">Опрос</p>
        <div class="article-block_poll-h">
            <h3>{{ $poll->question }}</h3>
        </div>

        @if (! $result['vote'])
            <form action="{{ route('front.polls.vote') }}" method="post">
                <input type="hidden" name="id" value="{{ $poll->id }}">

                @foreach ($poll->options as $option)
                    <label class="makeup-radio"><input type="radio" value="{{ $option->id }}" name="answer"><span
                                class="makeup-radio_btn"></span><span
                                class="makeup-radio_label">{{ $option->answer }}</span></label>
                @endforeach

                <div class="makeup-btn-wrap">
                    <input type="submit" disabled="disabled" value="Ответить" class="makeup-btn reg-btn red-bg">
                </div>
            </form>
        @else
            @php
                $options = $poll->options;
                $count = $options->sum('votes_count');
            @endphp
            <ul class="article-block_poll-result">
                @foreach ($options as $option)
                    @php
                        $percent = ($count == 0) ? 0 : round(($option->votes->count() / $count)*100);
                    @endphp
                    <li><span class="answer">{{ $option->answer }}</span> <span
                                class="result">{{ $percent }}%</span><span class="path"><i style="width:{{ $percent }}%"
                                                                                           class="path-filled"></i></span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
