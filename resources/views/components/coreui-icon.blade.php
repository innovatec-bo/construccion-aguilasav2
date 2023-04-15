<svg 
    class="{{$svgClass}}" 
    @if (isset($width))
        width="{{$width}}"
    @endif
    @if (isset($height))
        width="{{$height}}"
    @endif
    >
    <use xlink:href="{{asset('coreui/vendors/@coreui/icons/svg/free.svg#')}}{{$icon}}"></use>
</svg>