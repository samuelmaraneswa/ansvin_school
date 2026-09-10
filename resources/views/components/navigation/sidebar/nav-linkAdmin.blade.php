@props(['name', 'href'])

<a href="{{$href}}" {{$attributes}} class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300 cursor-pointer hover:bg-gray-900">
  {{$name}}
</a>