@auth
  <div class="relative" data-menu-wrapper>
    <div class="" data-action="toggle-menu">
      <img src="{{auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/img-default.png') }}" alt="" class="rounded-full w-9 h-9 bg-white cursor-pointer">

      <button class="absolute -bottom-0.5 cursor-pointer right-0 bg-white  text-black rounded-full text-xs flex items-center justify-center w-4 h-4">
        <i class="fa-solid fa-chevron-down"></i>
      </button>
    </div>

    <div class="hidden absolute w-30 right-0 bg-white shadow text-black rounded border border-gray-200" data-menu>
      <a href="{{route('admin.dashboard')}}" class="block px-4 py-2 border-b border-gray-200 hover:bg-gray-100">Dashboard</a>
      <a href="" class="block px-4 py-2 border-b border-gray-200 hover:bg-gray-100">Profile</a>
      
      <form action="{{route('logout')}}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2 border-b border-gray-300 cursor-pointer hover:bg-gray-100 w-full text-left">Logout</button>
      </form>

    </div>
  </div>
@endauth

@guest
  <a href="{{route('login')}}" class="shrink-0 bg-white text-black rounded px-2 py-1 overflow-hidden hover:bg-gray-100 cursor-pointer">
    Login
  </a>
@endguest
