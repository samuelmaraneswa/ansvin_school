@auth
  <div class="overflow-hidden" data-submenu-wrapper>
    <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
      <img src="{{auth()->user()->avatar === 'img-default.png' ? asset('images/' . auth()->user()->avatar) : asset('storage/' . auth()->user()->avatar) }}" alt="" class="rounded-full w-9 h-9 bg-gray-200 cursor-pointer" alt="">
      <i class="fa-solid fa-chevron-down"></i>
    </button>

    <div class="hidden" data-submenu>
      <div class="flex flex-col">
        <a href="{{route('admin.dashboard')}}" class="px-6 py-2 border-b border-gray-300 text-[17px]">Dashboard</a>
        <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Profile</a>

        <form action="{{route('logout')}}" method="POST">
          @csrf
          <button type="submit" class="px-6 py-2 border-b border-gray-300 text-[17px]">Logout</button>
        </form>
      </div>
    </div>
  </div>    
@endauth

@guest
  <a href="{{route('login')}}" class="px-4 py-2 border-b border-gray-300">Login</a>
@endguest