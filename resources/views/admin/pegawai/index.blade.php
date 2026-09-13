<x-layouts.adminApp>
  <div class="p-6 flex items-center gap-4">

    <x-partials.ui.titlePageAdmin name="Pegawai" />

    {{-- form search start --}}
    <x-partials.ui.formSearchAdmin search="pegawai" />
    {{-- form search end --}}

    <x-partials.ui.tambahBtnAdmin name="Tambah" data-action="navigate-admin" link="{{route('admin.pegawai.create')}}" />

  </div>

  {{-- table start --}}
  <x-partials.ui.tableUserAdmin :pegawai="$pegawai" />
  {{-- table end --}}
</x-layouts.adminApp> 