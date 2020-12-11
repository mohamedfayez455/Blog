<div class="col-6 col-md-3 sidebar-offcanvas">

    <ul class="list-group">
        <li class="list-group-item">Archives</li>
        @foreach($archives as $state)
            <li class="list-group-item">
                <a href="{{route('archives' , ['month' =>$state['month'] , 'year' => $state['year']])}}">
                    {{$state['month'] .' '. $state['year']}}
                </a>
            </li>
        @endforeach
    </ul>

    <ul class="list-group">
        <li class="list-group-item">Tags</li>
        @foreach($tags as $tag)
            <li class="list-group-item">
                <a href="{{route('tags.show' ,$tag->id)}}">
                    {{$tag->name}}
                </a>
            </li>
        @endforeach
    </ul>

    <ul class="list-group">
        <li class="list-group-item">Your Tags</li>
        @foreach($tags as $tag)
            <li class="list-group-item">
                <a href="{{route('tags.show' ,$tag->id)}}">
                    {{$tag->name}}
                </a>
            </li>
        @endforeach
    </ul>

</div>