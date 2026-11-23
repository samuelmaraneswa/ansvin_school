<x-layouts.adminApp>
  <div class="p-4 md:p-6 flex items-center gap-4">

    <x-partials.ui.titlePageAdmin name="Semester" />

    {{-- form search start --}}
    <x-partials.ui.formSearchAdmin search="semester" name="Semester" />
    {{-- form search end --}}

    <button class="border rounded bg-gray-100 hover:bg-white px-2 py-1.5 cursor-pointer" action="admin-tambah-semester">
      <i class="fa-solid fa-plus"></i>
      Tambah
    </button>
  </div>

  {{-- table start --}}
  <div class="overflow-hidden rounded w-full mt-6 px-2">
    <table class="w-full border border-gray-300">
      <thead class="bg-indigo-500 text-white">
        <tr class="w-full">
          <th class="px-4 py-2 text-left">No</th>
          <th class="px-4 py-2 text-left">Tahun Ajaran</th>
          <th class="px-4 py-2 text-left">Semester</th>
          <th class="px-4 py-2 text-left">Tgl Mulai</th>
          <th class="px-4 py-2 text-left">Tgl Selesai</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Action</th>
        </tr>
      </thead>
      <tbody table-admin-semester></tbody>
    </table>

    <div class="mt-6 flex items-center justify-center p-4 gap-4" admin-pagination="semester"></div>
  </div>
  {{-- table end --}}

  <div class="opacity-0 invisible transition-all duration-300 fixed inset-0 bg-black/50 z-50 flex justify-center px-2 pt-30 md:p-20" modal-admin-semester>

    <div class="relative w-125 translate-y-3.75 transition-transform duration-300" modal-content>

      <button class="absolute -right-3 -top-3 z-10 text-red-500 bg-gray-100 hover:bg-white px-1 py-0.5 cursor-pointer border border-gray-300 rounded-full" action="close-modal-semester">
        <i class="fa-solid fa-x"></i>
      </button>

      <div class="bg-white rounded-lg shadow-lg max-h-120 overflow-y-auto md:p-6 p-2">

        <h2 class="text-lg font-semibold" title-semester></h2>
        <hr class="mt-2 text-gray-300">

        @include('admin.semester.partials.form', [
          'semester' => null,
          'storeUrl' => route('admin.semester.store'),
          'updateUrl' => route('admin.semester.update', ['semester' => ':id'])
        ])
      </div>
    </div>

  </div>

</x-layouts.adminApp> 