@extends('layouts.header')

@section('content')

<main class="text-center mb-4">
    <x-notify::notify />
    @notifyJs
    @php
      session()->forget('notify.notification');
    @endphp
  <!-- Konten halaman utama -->
  <div class="container mx-auto">
    <div class="grid grid-cols-1 gap-5 px-10 lg:grid-cols-12">
      <div class="col-span-12 md:col-span-8 lg:col-start-4">
        <div class="md:text-left">
          <h2 class="mt-8 mb-1 text-2xl text-center md:text-start font-semibold text-gray-700">
            My Requests
          </h2>
          <p class="text-center md:text-start">{{ $dataAll->count() }} Requests</p>
        </div>
      </div>
      <div class="col-span-12 md:col-span-10 lg:col-start-4">
          <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="w-full border-collapse bg-white">
              <thead>
                  <tr class="bg-gray-100">
                      <th class="border-b border-gray-300 px-4 py-2">Kode</th>
                      <th class="border-b border-gray-300 px-4 py-2">Diterima Dari</th>
                      <th class="border-b border-gray-300 px-4 py-2">Nominal</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                    <td class="border-b border-gray-300 text-blue-500 flex flex-col group">
                      {{ $item->code }}
                      <span class="text-blue-500 text-sm opacity-0 group-hover:opacity-100">
                        <a href="{{ route('request.show', ['code' => $item->id]) }}" target="_blank">Cetak</a>
                        | <a class="text-red-500" href="{{ route('request.softDelete', ['id' => $item->id]) }}">Hapus</a></span>
                    </td>
                    <td class="border-b border-gray-300">{{ $item->received_from }}</td>
                    <td class="border-b border-gray-300">Rp {{ number_format($item->payment_number, 0, ',' , '.' )  }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
        <div class="mt-3">
              {{ $data->links() }}
        </div>
      </div>
    </div>
  </div>
</main>

@endsection
