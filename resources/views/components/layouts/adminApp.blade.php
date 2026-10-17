<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Document</title>

  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- sweet-alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const pegawaiRoutes = {
      index: @json(route('admin.pegawai.index')),
      suggestion:@json(route('admin.pegawai.suggestion')),
      show: @json(route('admin.pegawai.show', '__ID__')),
      edit: @json(route('admin.pegawai.edit', '__ID__')),
      destroy: @json(route('admin.pegawai.destroy', '__ID__')),
    }
  </script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <x-header.adminHeader />

  <div class="flex ">
    <x-sidebar.adminSidebar />

    <main data-content="admin" class="flex-1 min-w-0">
      {{$slot}}
    </main>
  </div>

</body>

</html>