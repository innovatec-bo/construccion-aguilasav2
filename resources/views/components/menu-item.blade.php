@if (isset($item['header']))
    <li class="nav-title">{{$item['header']}}</li>
@else
    <li class="{{isset($item['submenu'])?'nav-group': 'nav-item' }}">
        <a class="nav-link {{$isActive && !isset($item['submenu'])?'active':''}} {{isset($item['submenu'])?'nav-group-toggle': '' }}" href="{{isset($item['submenu'])?'#': route($item['route']) }}">
            <svg class="nav-icon">
                <use xlink:href="../coreui/vendors/@coreui/icons/svg/free.svg#{{$item['icon']}}"></use>
            </svg> 
            {{$item['text']}}
            {{-- <span class="badge badge-sm bg-info ms-auto">NEW</span> --}}
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