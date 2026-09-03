@props(['name', 'active' => false])

<div class="relative hover:bg-white hover:text-black hover:rounded" data-menu-wrapper>
  <button {{$attributes->class(['cursor-pointer px-2 py-1 rounded', 'font-semibold' => !$active, 'bg-white text-black font-normal rounded' => $active])}} data-action="toggle-menu">
    {{$name}}

    <i class="fa-solid fa-chevron-down ml-3"></i>
  </button>

  <div class="absolute hidden bg-white border border-red-500 rounded shadow text-black w-40 overflow-hidden" data-menu>
    {{$slot}}
  </div>
</div>