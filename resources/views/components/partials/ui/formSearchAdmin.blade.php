@props(['search', 'name' => null])

<div class="flex-1 w-full">
  <form class="relative" data-search-form="{{$search}}">
    
    <input type="text" class="border px-4 pr-15 focus:outline-none py-1.5 rounded w-full bg-gray-100" placeholder="Search {{$name}}..." data-search-input>

    <button type="button" class="absolute hidden top-1/2 -translate-y-1/2 right-9 text-[12px] text-red-700 cursor-pointer" data-action="clear-input">
      <i class="fa-solid fa-x"></i>
    </button>

    <button type="submit" class="absolute  top-1/2 -translate-y-1/2 right-2 text-gray-500">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>

    {{-- suggestion start --}}
    <div class="absolute hidden w-full top-full border bg-white rounded max-h-90 overflow-y-auto" data-search-suggestion></div>
    {{-- suggestion end --}}
  </form>
</div>