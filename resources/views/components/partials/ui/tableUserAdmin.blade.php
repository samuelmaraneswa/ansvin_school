@props(['pegawai'])

<div class="px-6 pt-3">
  <table class="w-full rounded overflow-hidden text-left">
    <thead class="bg-indigo-500 text-white">
      <tr>
        <th class="py-2 pl-4">No</th>
        <th class="py-2 pl-4">Nama</th>
        <th class="py-2 pl-4">Login ID</th>
        <th class="py-2 pl-4">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pegawai as $index => $item)
        <tr>
          <td class="px-4 py-2">
            {{ $pegawai->firstItem() + $index }}
          </td>

          <td class="px-4 py-2">
            {{ $item->user->name }}
          </td>

          <td class="px-4 py-2">
            {{ $item->user->login_id }}
          </td>

          <td class="px-4 py-2 flex items-center gap-3">
            <a href="{{route('admin.pegawai.show', $item->id)}}" class="border bg-gray-100 hover:bg-white px-3 py-1 rounded" data-action="navigate-admin">
                Detail
            </a>

            <a href="{{route('admin.pegawai.edit', $item->id)}}" class="bg-green-700 text-white! hover:bg-green-600 px-3 py-1 rounded" data-action="navigate-admin">
                Edit
            </a>

            <form action="" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="border bg-red-700 hover:bg-red-600 text-white cursor-pointer px-3 py-1 rounded">
                    Delete
                </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>