<x-layouts.adminApp>
  <div class="p-6">

    <h2 class="text-xl">Tambah Pegawai</h2>

    <x-partials.ui.formPegawai store-url="{{route('admin.pegawai.store')}}" index-url="{{route('admin.pegawai.index')}}" />

  </div>
</x-layout.adminApp>