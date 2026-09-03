@props(['name', 'href', 'active' => false])

<a href="{{$href}}" {{$attributes->class(['hover:bg-white hover:text-black', 'px-2 py-1 rounded', 'font-semibold' => !$active, 'bg-white text-black' => $active])}}>
  {{$name}}
</a>