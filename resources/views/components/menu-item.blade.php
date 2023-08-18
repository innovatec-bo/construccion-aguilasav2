
@if (isset($item['header']))
    <li class="nav-title">{{$item['header']}}</li>
@else
    @if (isset($item['url']))
        <li class="{{isset($item['submenu'])?'nav-group': 'nav-item' }}">
            <a class="nav-link {{$isActive && !isset($item['submenu'])?'active':''}} {{isset($item['submenu'])?'nav-group-toggle': '' }}" href="{{isset($item['submenu'])?'#': $item['url'] }}">
                <x-coreui-icon svgClass="nav-icon" icon="{{$item['icon']}}"/>
                {{$item['text']}}
            </a>
            @if (isset($item['submenu']))
                <ul class="nav-group-items">
                    @foreach ($item['submenu'] as $subItem)
                        <li class="nav-item">
                            <a class="nav-link" href="{{$subItem['url']}}">
                                <span class="nav-icon"></span> {{$subItem['text']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @else
        <li class="{{isset($item['submenu'])?'nav-group': 'nav-item' }}">
            <a class="nav-link {{$isActive && !isset($item['submenu'])?'active':''}} {{isset($item['submenu'])?'nav-group-toggle': '' }}" href="{{isset($item['submenu'])?'#': route($item['route']) }}">
                <x-coreui-icon svgClass="nav-icon" icon="{{$item['icon']}}"/>
                {{$item['text']}}
            </a>
            @if (isset($item['submenu']))
                <ul class="nav-group-items">
                    @foreach ($item['submenu'] as $subItem)
                        <li class="nav-item">
                            <a class="nav-link {{request()->routeIs($subItem['route'])?'active':''}}" href="{{route($subItem['route'])}}">
                                <span class="nav-icon"></span> {{$subItem['text']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>        
    @endif
@endif
