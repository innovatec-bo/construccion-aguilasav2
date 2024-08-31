<li class="menu-item {{$isActive?'active':''}} {{$isOpen?'open':''}}">
    <a href="{{isset($item['submenu'])?'javascript:void(0);': route($item['route']) }}" class="menu-link {{isset($item['submenu'])?'menu-toggle':''}}">
        <i class="menu-icon {{$item['icon']}}"></i>
        <div>{{$item['text']}}</div>
    </a>
    @if (isset($item['submenu']))
        <ul class="menu-sub">
            @foreach ($item['submenu'] as $subItem)
                <li class="menu-item {{request()->routeIs($subItem['route'])?'active':''}}">
                    <a href="{{route($subItem['route'])}}" class="menu-link">
                        <div>{{$subItem['text']}}</div>
                    </a>
                </li>    
            @endforeach
        </ul>
    @endif    
</li>