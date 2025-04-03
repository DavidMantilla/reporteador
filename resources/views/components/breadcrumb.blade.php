<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    @php

       $uri= explode('?', $uri)[0];
        $url = explode('/', $uri);
        $final = end($url);
    @endphp
    <nav aria-label='breadcrumb'>
        <ol class='breadcrumb'>

            @if (strcmp($uri, '/empresa') == 0)
                <li class='breadcrumb-item'><b>Inicio<b></li>
            @else
                @foreach ($url as $key => $value)
                    @if ($key > 0)
                        @if ($value != $final)
                            <li class='breadcrumb-item'><b><a href='/{{ $value }}'>{{ $value }}</a></b></li>
                        @else
                            <li class='breadcrumb-item active' aria-current='page'><b>{{ $value }}</b></li>
                        @endif
                    @else
                        <li class='breadcrumb-item'><a href='/empresa'><b>Inicio</b></a></li>
                    @endif
                @endforeach

            @endif


        </ol>
    </nav>


</div>
