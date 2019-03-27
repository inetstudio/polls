<div class="ibox-content">
    <h2 class="m-b-lg">{{ $item['question'] }}</h2>
    <div>
        @foreach ($item['options'] as $option)
            <div>
                <span>{{ $option['answer'] }}</span>
                <small class="float-right">{{ $option['votes_percent'].'% ('.$option['votes'].')' }}</small>
            </div>
            <div class="progress progress-small m-b-lg">
                <div style="width: {{ $option['votes_percent'] }}%;" class="progress-bar"></div>
            </div>
        @endforeach
    </div>
</div>
