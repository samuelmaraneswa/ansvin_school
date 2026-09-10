<aside class="hidden md:block bg-gray-700 text-white w-68.75 h-[calc(100vh-52px)] overflow-y-auto">
  <x-partials.sidebar.formSearchSidebarAdmin />

  <div class="mt-4">

    <x-navigation.sidebar.nav-linkAdmin name="Dashboard" href="{{route('admin.dashboard')}}" data-action="navigate-admin" />

    <x-navigation.sidebar.nav-dropdownAdmin name="User">
      <x-partials.sidebar.nav-link name="Pegawai" link="{{route('admin.pegawai.index')}}" data-action="navigate-admin" /> 
      <x-partials.sidebar.nav-link name="Siswa" link="#" /> 
    </x-navigation.sidebar.nav-dropdownAdmin>

  </div>
</aside>