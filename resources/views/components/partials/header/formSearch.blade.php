@props(['name' => null])

<div class="relative flex-1 min-w-0">
  <input type="text" placeholder="Search {{$name}}..." class="w-full px-2 py-1 rounded bg-gray-100 focus:outline-none text-black pr-7">
  <button class="absolute right-2 top-1/2 -translate-y-1/2"><i class="fa-solid fa-magnifying-glass text-gray-500"></i></button>
</div>