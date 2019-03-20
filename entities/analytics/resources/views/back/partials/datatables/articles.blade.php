<ul class="list-group">
@foreach ($items as $item)
    <li class="list-group-item"><a href="{{ $item['href'] }}" target="_blank">{{ $item['title'] }}</a></li>
@endforeach
</ul>