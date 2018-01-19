@php
    $options = $poll->options;
    $count = 0;
    foreach ($options as $option) {
        $count += $option->votes_count;
    }
@endphp

<div class="ibox-content">
    <h2>{{ $poll->question }}</h2>
    <div>
        @foreach ($poll->options as $option)
            <div>
                <span>{{ $option->answer }}</span>
                <small class="pull-right">{{ $option->votes_count }}</small>
            </div>
            @php
                $percent = ($count == 0) ? 0 : round(($option->votes_count / $count)*100);
            @endphp
            <div class="progress progress-small">
                <div style="width: {{ $percent }}%;" class="progress-bar"></div>
            </div>
        @endforeach
    </div>
</div>
