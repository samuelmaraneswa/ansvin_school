@props(['name'])

<div class="" data-submenu-wrapper>
  <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300 cursor-pointer hover:bg-gray-900" data-action="toggle-submenu">
    <span>{{$name}}</span><i class="fa-solid fa-chevron-down text-sm cursor-pointer"></i>
  </button>

  <div class="hidden" data-submenu>
    <div class="flex flex-col">
      {{$slot}}
    </div>
  </div>
</div> 