<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <x-layouts.authHeader />

  {{-- form login --}}
  <div class="flex items-center justify-center mt-10 p-1 md:p-0">
    <div class="w-120 overflow-hidden rounded shadow border border-red-100">
      {{-- header --}}
      <div class="text-red-600 font-semibold text-xl p-4 border-b border-red-100">
        <h1>Login</h1>
      </div>

      {{-- body --}}
      <div class="">

        <form action="{{route('login.store')}}" data-form-login>
          @csrf

          <p data-login-error class="text-red-600 text-center mt-4"></p>

          <div class="flex items-start p-4">
            <label for="username" class="w-22 md:w-42 block pt-1 shrink-0">Username</label>
            <span class="pt-1 mr-1">:</span>
            <div class="flex-1">
              <input type="text" id="username" placeholder="Username..." name="username" class="border border-gray-300 rounded px-2 py-1 focus:outline-none w-full" data-login-username autocomplete="off">
              <p class="text-red-600 text-sm mx-2 italic" data-error-field="username"></p>
            </div>
          </div>
          
          <div class="flex items-start p-4">
            <label for="password" class="w-22 md:w-42 block pt-1 shrink-0">Password</label>
            <span class="pt-1 mr-1">:</span>

            <div class="flex-1">
              <div class="relative">
                <input type="password" id="password" placeholder="Password..." name="password" class="border border-gray-300 rounded px-2 py-1 focus:outline-none w-full" data-login-password autocomplete="off">

                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer" data-action="toggle-eye">
                  <i class="fa-solid fa-eye-slash"></i>
                </button>
              </div>

              <p class="text-red-600 text-sm mx-2 italic" data-error-field="password"></p>
            </div>
          </div>

          <button type="submit" id="btnLogin" class="block mx-auto my-4 bg-red-500 text-white px-2 py-1 rounded cursor-pointer hover:bg-red-600">Login</button>
        </form>
      
      </div>

    </div>
  </div>
</body>
</html>