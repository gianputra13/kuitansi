@extends('layouts.header')

@section('content')
<main class="text-center">
  <!-- Konten halaman utama -->
  <div class="container mx-auto">
    <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
      <div class="col-span-8 col-start-4 flex justify-between items-center">
        <div>
            <h2 class="mt-8 mb-1 text-2xl text-start font-semibold text-gray-700">
                Add Data
            </h2>
        </div>
      </div>
      <div class="col-span-6 col-start-4 lg:text-right">
        <form action="/form/submit" method="POST" class="mt-4 text-start">
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                  <label for="received_from" class="block text-sm font-medium text-gray-700">Telah diterima Dari</label>
                  <input type="received_from" id="received_from" name="received_from" class="px-4 py-2 mt-1 block w-full border-gray-300 rounded-md " required>
              </div>
              <div>
                <label for="type_payment" class="block text-sm font-medium text-gray-700">Tipe Pembayaran</label>
                <select id="type_payment" name="type_payment" class="px-1 py-[10.5px] mt-1 block w-full border-gray-300 rounded-md" required>
                  <option value="Transfer">Transfer</option>
                  <option value="Tunai">Tunai</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div class="mb-4 mt-4">
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                <input type="date" id="payment_date" name="payment_date" class="px-4 py-2 mt-1 block w-full border-gray-300 rounded-md" value="{{ date('Y-m-d') }}" required>
              </div>
              <div class="mb-4 mt-4">
                <div>
                    <label for="payment_number" class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                    <input type="number" inputmode="numeric" id="payment_number" name="payment_number" class="px-4 py-2 mt-1 block w-full border-gray-300 rounded-md " required>
                </div>
              </div>
            </div>
            <div class="mb-4 mt-4">
                <label for="for_payment" class="block text-sm font-medium text-gray-700">Untuk Pembayaran</label>
                <textarea id="for_payment" name="for_payment" rows="4" class="px-4 py-2 mt-1 block w-full border-gray-300 rounded-md " required></textarea>
            </div>
            <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: #0167db !important; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#0053b3';" onmouseout="this.style.backgroundColor='#0167db';">Submit</button>
        </form>
      </div>
    </div>
  </div>
</main>

@endsection