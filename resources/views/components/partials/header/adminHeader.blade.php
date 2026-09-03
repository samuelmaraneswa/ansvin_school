<div class="bg-gray-800 text-white flex items-center px-3 md:px-4 py-1 justify-between">
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
    <div class="text-xl md:hidden relative" data-menu-wrapper>
      <button data-action="toggle-menu">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div class="hidden absolute right-0 bg-white border border-gray-300 text-black rounded w-40 text-[18px]" data-menu>
        <div class="" data-submenu-wrapper>
          <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
            <span>Jabatan</span><i class="fa-solid fa-chevron-down text-[14px]"></i>
          </button>

          <div class="hidden" data-submenu>
            <div class="flex flex-col">
              <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Pegawai</a>
              <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Siswa</a>
            </div>
          </div>
        </div>

        <div class="" data-submenu-wrapper>
          <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
            <img src="{{auth()->user()->avatar === 'img-default.png' ? asset('images/' . auth()->user()->avatar) : asset('storage/' . auth()->user()->avatar) }}" alt="" class="rounded-full w-9 h-9 bg-gray-200 cursor-pointer" alt="">
            <i class="fa-solid fa-chevron-down text-[14px]"></i>
          </button>

          <div class="hidden" data-submenu>
            <div class="flex flex-col">
              <a href="{{route('home')}}" class="px-6 py-2 border-b border-gray-300 text-[17px]">HomePage</a>
              <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Profile</a>
              
              <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 border-b border-gray-300 text-[17px]">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    {{-- hamburger end --}}

    <div class="hidden md:block md:relative" data-menu-wrapper>
      <div class="relative" data-action="toggle-menu">
        <img src="{{auth()->user()->avatar === 'img-default.png' ? asset('images/img-default.png') : asset('storage/' . auth()->user()->avatar)}}" alt="" class="h-8.5 w-8.5 rounded-full bg-white cursor-pointer">

        <button class="absolute -bottom-0.5 cursor-pointer right-0 bg-white  text-black rounded-full text-xs flex items-center justify-center w-4 h-4">
          <i class="fa-solid fa-chevron-down"></i>
        </button>
      </div>

      <div class="hidden absolute w-30 bg-white border border-gray-300 shadow right-0 text-black rounded" data-menu>
        <a href="{{route('home')}}" class="block px-4 py-2 border-b border-gray-300 hover:bg-gray-100 cursor-pointer">HomePage</a>
        <a href="" class="block px-4 py-2 border-b border-gray-300 hover:bg-gray-100 cursor-pointer">Profile</a>
        
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <button type="submit" class="px-4 py-2 border-b border-gray-300">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>