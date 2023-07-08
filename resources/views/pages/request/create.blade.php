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
        <form action="/form/submit" method="POST" class="mt-4 text-start" id="myForm">
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
            <div class="flex items-center">
              <button id="submitButton" type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: #0167db !important; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#0053b3';" onmouseout="this.style.backgroundColor='#0167db';">Submit</button>
            
              <div id="spinner" class="ml-4 hidden">
                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-1.647zM20 12c0-3.042-1.135-5.824-3-7.938l-3 1.647A7.962 7.962 0 0120 12h4a8 8 0 01-8 8v-4zm-2-5.291l3 1.647A7.962 7.962 0 0120 12h-4a4.02 4.02 0 00-3.88-3.283L15.709 6.71zM9.172 9.172l-1.414 1.414A2.99 2.99 0 007 12H5.99C5.999 10.348 7.15 8.86 8.586 7.928l.586-.586z"></path>
                </svg>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
const myForm = document.getElementById('myForm');
const submitButton = document.getElementById('submitButton');
const spinner = document.getElementById('spinner');

myForm.addEventListener('submit', () => {
  submitButton.style.display = 'none';
  
  spinner.classList.remove('hidden');
});
</script>

@endsection