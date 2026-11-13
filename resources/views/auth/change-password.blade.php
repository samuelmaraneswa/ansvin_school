<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- sweet-alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const changePasswordRoutes = {
      update: @json(route('password.update')),
    }
  </script>
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <x-header.authHeader />
  
  <div class="md:bg-gray-100 md:w-170 p-6 space-y-4 mx-auto mt-5 rounded">
    <div class="">
      <h2 class="text-lg font-semibold">Change Password</h2>
      <hr class="my-2">

      <p class="mb-2">Harap mengganti password Anda agar dapat mengakses website!</p>

      <p class="italic text-red-500">* Harap mengingat password Anda atau menyalinnya. *</p>
      <p class="italic text-red-500">* Gunakan password dengan kombinasi huruf dan angka. *</p>
      <p class="italic text-red-500">* Password minimal 8 karakter. *</p>
    </div>

    <form method="" action="" data-form-change_password>

      <div class="mt-10 space-y-6">
        @csrf

        <div class="flex">
          <label for="" class="inline-block w-20 shrink-0">Password Lama</label>
          <span class="mr-1">: </span>

          <div class="flex flex-col flex-1">
            <div class="relative">
              <input type="password" name="password_lama" class="border rounded focus:outline-none px-2 py-0.5 w-full min-w-0" data-changePassword-password_lama>

              <button type="button" data-action="toggle-eye" class="absolute right-0 top-1/2 -translate-y-1/2 cursor-pointer mx-2">
                <i class="fa-solid fa-eye-slash"></i>
              </button>
            </div>

            <span data-error-field="password_lama" class="text-red-600 text-sm pt-1 italic"></span>
          </div>
        </div>

        <div class="flex">
          <label for="" class="inline-block w-20 shrink-0">Password Baru</label>
          <span class="mr-1">:</span>

          <div class="flex flex-col flex-1">
            <div class="relative">
              <input type="password" name="password_baru" class="border rounded focus:outline-none px-2 py-0.5 w-full min-w-0" data-changePassword-password_baru>

              <button type="button" data-action="toggle-eye" class="absolute right-0 top-1/2 -translate-y-1/2 cursor-pointer mx-2">
                <i class="fa-solid fa-eye-slash"></i>
              </button>
            </div>

            <span data-error-field="password_baru" class="text-red-600 text-sm pt-1 italic"></span>
          </div>
        </div>

        <div class="flex">
          <label for="" class="inline-block w-20 shrink-0">Confirm Password</label>
          <span class="mr-1">:</span>

          <div class="flex flex-col flex-1">
            <div class="relative">
              <input type="password" name="confirm_password" class="border rounded focus:outline-none px-2 py-0.5 w-full min-w-0" data-changePassword-confirm_password>

              <button type="button" data-action="toggle-eye" class="absolute right-0 top-1/2 -translate-y-1/2 cursor-pointer mx-2">
                <i class="fa-solid fa-eye-slash"></i>
              </button>
            </div>

            <span data-error-field="confirm_password" class="text-red-600 text-sm pt-1 italic"></span>
          </div>
        </div>

        <button id="btnChangePassword" class="block mx-auto bg-green-600 text-white rounded px-2 py-1 hover:bg-green-500 cursor-pointer">Simpan</button>
      </div>

    </form>
  </div>

</body>
</html>