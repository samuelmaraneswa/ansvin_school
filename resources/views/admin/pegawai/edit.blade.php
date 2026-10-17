<x-layouts.adminApp>
  <div class="p-6">

    <h2 class="text-xl">Edit Pegawai</h2>

    <x-partials.ui.formPegawai :pegawai="$pegawai" update-url="{{route('admin.pegawai.update', $pegawai)}}" index-url="{{route('admin.pegawai.index')}}" />

  </div>
</x-layouts.adminApp>