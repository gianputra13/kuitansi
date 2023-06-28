<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <title>Kuitansi</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        @notifyCss
    </head>
    <body class="bg-gray-300 font-[Poppins]">
        <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="Openbar()">
          <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
        </span>

        <div class="sidebar fixed top-0 bottom-0 lg:left-0 left-[-280px] duration-1000
          p-2 w-[280px] overflow-y-auto text-center bg-white shadow h-screen">
          <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center rounded-md ">
              <i class="bi bi-app-indicator px-2 py-1 bg-blue-600 rounded-md"></i>
              <h1 class="text-[15px]  ml-3 text-xl text-gray-800 font-bold">Kuitansi</h1>
            </div>
            <hr class="my-2 text-gray-600">
            <div>

              <a href="{{ route('request.index') }}" class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer {{ request()->routeIs('request.index') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-house-door-fill text-gray-800 {{ request()->routeIs('request.index') ? 'text-white' : '' }}"></i>
                <span class="text-[15px] ml-4 text-gray-800 {{ request()->routeIs('request.index') ? 'text-white' : '' }}">My Requests</span>
              </a>
              <a href="{{ route('request.create') }}" class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer {{ request()->routeIs('request.create') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-bookmark-fill text-gray-800 {{ request()->routeIs('request.create') ? 'text-white' : '' }}"></i>
                <span class="text-[15px] ml-4 text-gray-800 {{ request()->routeIs('request.create') ? 'text-white' : '' }}">Add Data</span>
              </a>
              <hr class="my-4 text-gray-600">
            </div>
          </div>
        </div>

        @yield('content')

        <script>      
            function Openbar() {
              document.querySelector('.sidebar').classList.toggle('left[-300px]')
            }
        </script>
    </body>
</html>