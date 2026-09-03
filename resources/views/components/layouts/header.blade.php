<header class="bg-red-600 text-white">
  {{-- tampilan web start --}}
  <div class="hidden md:flex items-center justify-between px-4 py-1">
    {{-- kiri --}}
    <div class="flex items-center gap-2 w-50">
      <img src="{{asset('images/logo.png')}}" alt="" class="w-12 h-12 bg-white rounded object-contain">
      <h1 class="font-semibold text-xl">Ansvin School</h1>
    </div>

    {{-- tengah --}}
    <div class="flex-1 flex items-center justify-around px-4">
      <x-navigation.header.nav-link name="Home" href="/" :active="request()->routeIs('home')" />

      <x-navigation.header.nav-dropdown name="Profile" :active="request()->routeIs('profile.*')">
        <a href="{{route('profile.sejarah')}}" class="block px-4 py-1 hover:bg-gray-100 border-b border-gray-200">Sejarah</a>
        <a href="" class="block px-4 py-2 font-normal hover:bg-gray-100 border-b border-gray-200">Visi Misi</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 whitespace-nowrap">Struktur Organisasi</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Fasilitas</a>
      </x-navigation.header.nav-dropdown>
      
      <x-navigation.header.nav-dropdown name="Akademik" :active="request()->routeIs('akademik.*')">
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Guru dan Staff</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Kurikulum</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 whitespace-nowrap">Struktur Organisasi</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Fasilitas</a>
      </x-navigation.header.nav-dropdown>

      <x-navigation.header.nav-dropdown name="Informasi" :active="request()->routeIs('informasi.*')">
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Pendaftaran</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Artikel</a>
        <a href="" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200">Pengumuman</a>
      </x-navigation.header.nav-dropdown>

      <x-navigation.header.nav-link name="Gallery" href="/" :active="request()->routeIs('gallery')" />

      <x-navigation.header.nav-link name="Ekskul" href="/" :active="request()->routeIs('ekskul')" />

    </div>

    {{-- kanan --}}
    <div class="w-62.5 flex items-center gap-2">
      {{-- form search global --}}
      <x-partials.header.formSearch />

      {{-- login / profile user --}}
      <x-partials.header.profile />
    </div>
  </div>
  {{-- tampilan web end --}}

  {{-- tampilan mobile start --}}
  <div class="flex md:hidden items-center justify-between px-4 py-1">
    {{-- kiri --}}
    <a href="{{route('home')}}" class="flex items-center gap-2">
      <img src="{{asset("images/logo.png")}}" alt="" class="w-11 h-11 object-contain bg-white rounded-full p-1">
      <h1 class="font-semibold text-lg">Ansvin School</h1>
    </a>

    {{-- kanan --}}
    <div class="text-white text-lg gap-3 flex items-center">
      <div class="">
        <button data-action="toggle-mobile-search"><i class="fa-solid fa-magnifying-glass"></i></button>

        <div class="hidden fixed inset-0 bg-white p-4 text-black z-50" data-mobile-search>
          {{-- form search mobile --}}
          <div class="relative">
            <div class="flex items-center gap-2 relative">
              <button class="px-1.5 py-1 bg-gray-200 rounded-full" data-action="close-mobile-search">
                <i class="fa-solid fa-arrow-left"></i>
              </button>
              
              <input type="text" placeholder="Search..." class="rounded-full px-4 py-1 pr-7 bg-gray-200 focus:outline-none w-full">

              <button class="text-gray-500 absolute right-3 top-1/2 -translate-y-1/2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            {{-- suggesstion --}}
            <div class="hidden absolute mt-0.5 bg-white border border-gray-500 rounded shadow overflow-y-auto w-full max-h-150">
              
            </div>
          </div>

        </div>
      </div>
      
      <div class="relative" data-menu-wrapper>
        {{-- hamburger --}}
        <button data-action="toggle-menu">
          <i class="fa-solid fa-bars"></i>
        </button> 

        <div class="hidden absolute w-50 text-black bg-white border rounded right-0 max-h-100 overflow-y-auto" data-menu>
          <nav class="flex flex-col">
            <a href="" class="px-4 py-2 border-b border-gray-300">Home</a>

            <div class="" data-submenu-wrapper>
              <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
                <span>Profile</span><i class="fa-solid fa-chevron-down"></i>
              </button>

              <div class="hidden" data-submenu>
                <div class="flex flex-col">
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Sejarah</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Visi Misi</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 whitespace-nowrap text-[17px]">Struktur Organisasi</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Fasilitas</a>
                </div>
              </div>
            </div>
            
            <div class="" data-submenu-wrapper>
              <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
                <span>Akademik</span><i class="fa-solid fa-chevron-down"></i>
              </button>

              <div class="hidden" data-submenu>
                <div class="flex flex-col">
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Kurikulum</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Guru dan Staff</a>
                </div>
              </div>
            </div>
            
            <div class="" data-submenu-wrapper>
              <button class="flex items-center justify-between px-4 py-2 w-full border-b border-gray-300" data-action="toggle-submenu">
                <span>Informasi</span><i class="fa-solid fa-chevron-down"></i>
              </button>

              <div class="hidden" data-submenu>
                <div class="flex flex-col">
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Pendaftaran</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Artikel</a>
                  <a href="" class="px-6 py-2 border-b border-gray-300 text-[17px]">Pengumuman</a>
                </div>
              </div>
            </div>

            <a href="" class="px-4 py-2 border-b border-gray-300">Gallery</a>
            <a href="" class="px-4 py-2 border-b border-gray-300">Ekskul</a>

            <x-partials.header.profileMobile />
          </nav>

        </div>
      </div>
    </div>
  </div>
  {{-- tampilan mobile end --}}
</header>