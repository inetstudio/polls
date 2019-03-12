<div class="ibox-content">
    <h2>{{ $item['question'] }}</h2>
    <div>
        @foreach ($item['options'] as $option)
            <div>
                <span>{{ $option['answer'] }}</span>
                <small class="pull-right">{{ $option['votes_percent'].'% ('.$option['votes'].')' }}</small>
            </div>
            <div class="progress progress-small">
                <div style="width: {{ $option['votes_percent'] }}%;" class="progress-bar"></div>
            </div>
        @endforeach
    </div>
</div>
