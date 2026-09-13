<div class="sticky top-0 z-50 bg-gray-800 text-white flex items-center px-3 md:px-4 py-1 justify-between h-13">
  {{-- kiri --}}
  <div class="flex items-center gap-3">
    <a href="{{route('home')}}"><img src="{{asset('images/logo.png')}}" alt="" class="h-11 w-11 object-contain bg-white rounded-full md:rounded"></a>
    <a href="{{route('admin.dashboard')}}" class="text-xl font-semibold">Dashboard</a>
  </div>

  {{-- kanan --}}
  <div class="flex items-center gap-2 md:gap-4">
    <div class="flex items-center text-xl md:text-2xl gap-1 md:gap-2">
      <i class="fa-solid fa-bell"></i>
      <i class="fa-solid fa-comment"></i>
    </div>

    {{-- hamburger start --}}
    <x-partials.header.hamburgerAdmin />
    {{-- hamburger end --}}

    <div class="hidden md:block md:relative" data-menu-wrapper>
      <div class="relative" data-action="toggle-menu">
        <img src="{{auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/img-default.png') }}" alt="" class="h-8.5 w-8.5 rounded-full bg-white cursor-pointer">

        <button class="absolute -bottom-0.5 cursor-pointer right-0 bg-white  text-black rounded-full text-xs flex items-center justify-center w-4 h-4">
          <i class="fa-solid fa-chevron-down"></i>
        </button>
      </div>

      <div class="hidden absolute w-30 bg-white border border-gray-300 shadow right-0 text-black rounded" data-menu>
        <a href="{{route('home')}}" class="block px-4 py-2 border-b border-gray-300 hover:bg-gray-100 cursor-pointer">HomePage</a>
        <a href="" class="block px-4 py-2 border-b border-gray-300 hover:bg-gray-100 cursor-pointer">Profile</a>
        
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <button type="submit" class="px-4 py-2 border-b border-gray-300 cursor-pointer hover:bg-gray-100 w-full text-left">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>