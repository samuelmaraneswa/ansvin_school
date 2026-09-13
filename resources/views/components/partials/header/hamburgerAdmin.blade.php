<div class="text-xl md:hidden relative" data-menu-wrapper>
  <button data-action="toggle-menu">
    <i class="fa-solid fa-bars"></i>
  </button>

  <div class="hidden absolute right-0 bg-white border border-gray-300 text-black rounded w-40 text-[18px]" data-menu>
    <x-navigation.header.nav-link-hamburger link="{{route('admin.dashboard')}}" name="Dashboard" data-action="navigate-admin" />

    <x-navigation.header.nav-dropdown-hamburger name="User">
      <x-partials.header.nav-link-hamburger name="Pegawai" link="{{route('admin.pegawai.index')}}" data-action="navigate-admin" />
      <x-partials.header.nav-link-hamburger name="Siswa" link="#" />
    </x-navigation.header.nav-dropdown-hamburger>

    <div class="" data-submenu-wrapper>
      <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
        <img src="{{auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/img-default.png') }}" alt="" class="rounded-full w-9 h-9 bg-white cursor-pointer">
        
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