<x-layouts.adminApp>
  <div class="p-4 md:p-6">
    <!-- top -->
    <div class="">
      <h1 class="text-2xl font-bold">{{ucfirst($pegawai->user->name)}}</h1>

      <hr class="mt-4">

      <div class="flex items-center font-semibold mt-2">
        <label for="" class="block">Status </label>
        :<span class="ml-2 mr-2">Pegawai</span> |
        <label for="" class="block ml-2">Jabatan </label>
        :<span class="ml-2">Jabatan</span>
      </div>
    </div>

    <!-- body -->
    <div class="flex flex-col md:flex-row mt-6 gap-12 items-start">
      <!-- kiri -->
      <div class="">
        <img src="{{$pegawai->user->avatar ? Storage::url($pegawai->user->avatar) : asset('images/img-default.png')}}" alt="Avatar {{$pegawai->user->name}}" class="h-80 w-60 object-contain bg-gray-200 rounded">
      </div>

      <!-- kanan -->
      <div class="w-full overflow-x-auto">
        <div class="space-y-4">

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">Kode Pegawai</label>
            :<span class="ml-2">{{$pegawai->kode_pegawai ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">NIK</label>
            :<span class="ml-2">{{$pegawai->user->nik ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">Jenis Kelamin</label>
            :<span class="ml-2">{{$pegawai->user->jenis_kelamin ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">Tanggal Lahir</label>
            :<span class="ml-2">{{$pegawai->user->tgl_lahir ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">Tempat Lahir</label>
            :<span class="ml-2">{{$pegawai->user->tpt_lahir ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">Alamat</label>
            :<span class="ml-2">{{$pegawai->user->alamat ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40">No HP Lahir</label>
            :<span class="ml-2">{{$pegawai->user->no_hp ?? '-'}}</span>
          </div>

          <div class="flex items-center mt-2">
            <label for="" class="block w-30 md:w-40 shrink-0">Email</label>
            :<span class="ml-2">{{$pegawai->user->email ?? '-'}}</span>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-layouts.adminApp> 