@props([
  'pegawai' => null, 
  'storeUrl' => null, 
  'updateUrl' => null,
  'indexUrl' => null,
  ])

<div class="mt-6">

  <form action="" 
    data-form-pegawai 
    data-generate-kode="{{route('admin.pegawai.generateKode')}}"
    data-store-url="{{$storeUrl}}"
    data-update-url="{{$updateUrl}}"
    data-index-url="{{$indexUrl}}"
  >

    @csrf

    <input type="hidden" name="id" value="{{$pegawai?->id}}" data-pegawai-id>

    <div class="flex items-start mt-4">
      <label for="name" class="w-20 md:w-50 block pt-1">Nama <span class="hidden md:inline">Lengkap</span></label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">

        <input type="text" id="name" name="name" value="{{$pegawai?->user?->name}}" placeholder="Nama Lengkap..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-name>

        <p class="text-sm text-red-500 ml-4 italic" data-error-field="name"></p>

      </div>
    </div> 

    <div class="flex items-start mt-4">
      <label for="login_id" class="w-20 md:w-50 block pt-1">Login Id</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="text" id="login_id" name="login_id" value="{{$pegawai?->user?->login_id}}" placeholder="Login Id" class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded text-gray-500 cursor-not-allowed" autocomplete="off" readonly data-user-login_id>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="login_id"></p>
      </div>
    </div>

    <div class="flex items-start mt-4" data-field-row="kode_pegawai">
      <label for="kode_pegawai" class="kode_pegawai w-20 md:w-50 block pt-1">Kode <span class="hidden md:inline">Pegawai</span></label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1"> 
        <input type="text" id="kode_pegawai" name="kode_pegawai" value="{{$pegawai?->kode_pegawai}}" placeholder="Kode Pegawai..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded text-gray-500 cursor-not-allowed" autocomplete="off" readonly data-user-kode_pegawai>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="kode_pegawai"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="role" class="w-20 md:w-50 block pt-1">Role</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <select name="role" id="role" class="w-full border border-gray-300 px-2 py-1 cursor-pointer rounded" data-user-role>
          <option value="">--Pilih Role--</option>
          <option value="admin" @selected($pegawai?->user?->role === 'admin')>Admin</option>
          <option value="guru" @selected($pegawai?->user?->role === 'guru')>Guru</option>
        </select>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="role"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="nik" class="w-20 md:w-50 block pt-1">NIK</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="text" id="nik" name="nik" value="{{$pegawai?->user?->nik}}" placeholder="NIK..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-nik>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="nik"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="jenis_kelamin" class="w-20 md:w-50 block pt-1">Jenis Kelamin</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border border-gray-300 px-2 py-1 cursor-pointer rounded" data-user-jenis_kelamin>
          <option value="">--Pilih Jenis Kelamin--</option>
          <option value="L" @selected($pegawai?->user?->jenis_kelamin === 'L')>L</option>
          <option value="P" @selected($pegawai?->user?->jenis_kelamin === 'P')>P</option>
        </select>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="jenis_kelamin"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="tgl_lahir" class="w-20 md:w-50 block pt-1">Tpt Lahir</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="text" id="tgl_lahir" name="tgl_lahir" value="{{$pegawai?->user?->tpt_lahir}}" placeholder="Tempat Lahir..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-tgl_lahir>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="tgl_lahir"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="tgl_lahir" class="w-20 md:w-50 block pt-1">Tgl Lahir</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{$pegawai?->user?->tgl_lahir}}" placeholder="Tanggal Lahir..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-tgl_lahir>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="tgl_lahir"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="alamat" class="w-20 md:w-50 block pt-1">Alamat</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <textarea name="alamat" id="alamat" placeholder="Alamat..." class="border border-gray-300 rounded w-full px-2 py-1 focus:outline-none h-25" data-user-alamat>{{$pegawai?->user?->alamat}}</textarea>

        <p class="text-sm text-red-500 ml-4 italic" data-error-field="alamat"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="no_hp" class="w-20 md:w-50 block pt-1">No HP</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="text" id="no_hp" name="no_hp" value="{{$pegawai?->user?->no_hp}}" placeholder="No HP..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-no_hp>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="no_hp"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="email" class="w-20 md:w-50 block pt-1">Email</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <input type="email" id="email" name="email" value="{{$pegawai?->user?->email}}" placeholder="Email..." class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded" autocomplete="off" data-user-email>
        <p class="text-sm text-red-500 ml-4 italic" data-error-field="email"></p>
      </div>
    </div>

    <div class="flex items-start mt-4">
      <label for="avatar" class="w-20 md:w-50 block pt-1">Image</label>
      <span class="mr-2 pt-1">:</span>

      <div class="flex-1">
        <div class="flex flex-col">
          <input type="file" id="avatar" name="avatar" accept="image/*" class="border border-gray-300 focus:outline-none px-3 py-1 w-full rounded cursor-pointer" data-user-avatar>

          <p class="text-sm text-red-500 ml-4 italic" data-error-field="avatar"></p>
        </div>

        <span class="text-gray-500 text-sm italic">Preview:</span>
          <div class="mt-2">

            <img src="{{$pegawai?->user?->avatar ? asset('storage/' . $pegawai->user->avatar) : asset('images/img-default.png') }}" class="w-30 md:w-60 h-40 md:h-80 object-cover rounded border" alt="Avatar User" data-avatar-user-preview>

          </div>
      </div>
    </div>

    <div class="flex items-center justify-center mt-6 mb-8">
      <button type="submit" class="px-4 py-2 rounded text-white cursor-pointer bg-green-600 hover:bg-green-500" data-action="submit-pegawai">
        Simpan
      </button>
    </div>

  </form>

</div>