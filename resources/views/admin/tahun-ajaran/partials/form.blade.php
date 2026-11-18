<form action="" 
  form-tahun-ajaran
  data-store-url="{{$storeUrl}}"
  data-update-url="{{$updateUrl}}"
>
  @csrf

  <input type="hidden" name="id" value="{{$tahunAjaran->id ?? ''}}">

  <div class="mt-4 w-full flex">
    <label for="nama" class="w-20 md:w-30 inline-block pt-1">Name</label>
    <span class="mr-2 pt-1">: </span>

    <div class="flex-1 flex-col">
      <input type="text" name="nama" placeholder="Tambah tahun ajaran..." value="{{$tahunAjaran->nama ?? ''}}" class="w-full border border-gray-400 px-2 py-1 rounded focus:outline-none" autocomplete="off">
      <span class="text-red-500 italic text-sm" data-error-field="nama"></span>
    </div>
  </div>

  <div class="mt-4 w-full flex">
    <label for="tanggal_mulai" class="w-20 md:w-30 inline-block pt-1"><span class="md:hidden">Tgl Mulai</span><span  class="hidden md:block">Tanggal Mulai</span></label>
    <span class="mr-2 pt-1">: </span>

    <div class="flex-1 flex-col">
      <input type="date" name="tanggal_mulai" value="{{$tahunAjaran->tanggal_mulai ?? ''}}" class="w-full border border-gray-400 px-2 py-1 rounded focus:outline-none">
      <span class="text-red-500 italic text-sm" data-error-field="tanggal_mulai"></span>
    </div>
  </div>

  <div class="mt-4 w-full flex">
    <label for="tanggal_selesai" class="w-20 md:w-30 inline-block pt-1"><span class="md:hidden">Tgl Selesai</span><span class="hidden md:block">Tanggal Selesai</span></label>
    <span class="mr-2 pt-1">: </span>

    <div class="flex-1 flex-col">
      <input type="date" name="tanggal_selesai" value="{{$tahunAjaran->tanggal_selesai ?? ''}}" class="w-full border border-gray-400 px-2 py-1 rounded focus:outline-none">
      <span class="text-red-500 italic text-sm" data-error-field="tanggal_selesai"></span>
    </div>
  </div>

  <button class="border bg-green-600 text-white hover:bg-green-500 px-2 py-1 cursor-pointer rounded mt-4 mx-auto block">Simpan</button>

</form>