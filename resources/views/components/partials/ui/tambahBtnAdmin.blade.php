@props(['name', 'link'])

<a href="{{$link}}" {{$attributes}} class="border rounded bg-gray-100 hover:bg-white px-2 py-1.5 cursor-pointer"><i class="fa-solid fa-plus"></i>{{$name}}</a>