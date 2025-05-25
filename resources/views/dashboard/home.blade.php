<x-dashboard-layout title="Dashboard">
   <div class="max-w-7xl mx-auto px-4 xl:px-0 my-6">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 items-stretch">
         {{-- Pendapatan Card --}}
         <div
            class="bg-white shadow rounded-xl p-4 sm:p-5 hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
            <div class="flex-1 flex items-center space-x-4">
               <div class="bg-red-100 text-red-600 p-3 rounded-full size-16 flex items-center justify-center">
                  <i class="fas fa-dollar text-2xl"></i>
               </div>
               <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-800">Pendapatan</h3>
                  <div class="text-sm text-gray-600 mt-1 space-y-0.5">
                     <p class="font-medium">Hari Ini: <span class="font-bold text-gray-800">
                           @if ($income)
                              Rp{{ number_format($income['today'], 0, ',', '.') }}
                           @else
                              Rp0
                           @endif
                        </span></p>
                     <p class="font-medium">Bulan Ini: <span class="font-bold text-gray-800">
                           @if ($income)
                              Rp{{ number_format($income['monthly'], 0, ',', '.') }}
                           @else
                              Rp0
                           @endif
                        </span></p>
                  </div>
               </div>
            </div>
            <div class="mt-3 text-right">
               <a href="{{ route('products.index') }}" class="text-sm text-red-600 hover:underline font-medium">
                  Selengkapnya →
               </a>
            </div>
         </div>

         {{-- Users Card --}}
         <div
            class="bg-white shadow rounded-xl p-4 sm:p-5 hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
            <div class="flex-1 flex items-center space-x-4">
               <div class="bg-blue-100 text-blue-600 p-3 rounded-full size-16 flex items-center justify-center">
                  <i class="fas fa-users text-2xl"></i>
               </div>
               <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-800">Users</h3>
                  <div class="text-sm text-gray-600 mt-1 space-y-0.5">
                     <p>Admin: <span class="font-bold text-gray-800">{{ $users['admin'] }}</span></p>
                     <p>Karyawan: <span class="font-bold text-gray-800">{{ $users['user'] }}</span></p>
                  </div>
               </div>
            </div>
            <div class="mt-3 text-right">
               <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline font-medium">
                  Selengkapnya →
               </a>
            </div>
         </div>

         {{-- Produk Card --}}
         <div
            class="bg-white shadow rounded-xl p-4 sm:p-5 hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
            <div class="flex-1 flex items-center space-x-4">
               <div class="bg-green-100 text-green-600 p-3 rounded-full size-16 flex items-center justify-center">
                  <i class="fas fa-box text-2xl"></i>
               </div>
               <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-800">Produk</h3>
                  <div class="text-sm text-gray-600 mt-1">
                     <p>Jumlah: <span class="font-bold text-gray-800">{{ $products }}</span></p>
                  </div>
               </div>
            </div>
            <div class="mt-3 text-right">
               <a href="{{ route('products.index') }}" class="text-sm text-green-600 hover:underline font-medium">
                  Selengkapnya →
               </a>
            </div>
         </div>

         {{-- Penjualan Card --}}
         <div
            class="bg-white shadow rounded-xl p-4 sm:p-5 hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
            <div class="flex-1 flex items-center space-x-4">
               <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full size-16 flex items-center justify-center">
                  <i class="fas fa-shopping-cart text-2xl"></i>
               </div>
               <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-800">Penjualan</h3>
                  <div class="text-sm text-gray-600 mt-1">
                     <p>Jumlah: <span class="font-bold text-gray-800">{{ $orderCount }}</span></p>
                  </div>
               </div>
            </div>
            <div class="mt-3 text-right">
               <a href="{{ route('orders.index') }}" class="text-sm text-yellow-600 hover:underline font-medium">
                  Selengkapnya →
               </a>
            </div>
         </div>

         {{-- Pesanan Card --}}
         <div
            class="bg-white shadow rounded-xl p-4 sm:p-5 hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
            <div class="flex-1 flex items-center space-x-4">
               <div class="bg-purple-100 text-purple-600 p-3 rounded-full size-16 flex items-center justify-center">
                  <i class="fas fa-receipt text-2xl"></i>
               </div>
               <div class="flex-1">
                  <h3 class="text-base font-semibold text-gray-800">Pesanan</h3>
                  <div class="text-sm text-gray-600 mt-1">
                     <p>Jumlah: <span class="font-bold text-gray-800">0</span></p>
                  </div>
               </div>
            </div>
            <div class="mt-3 text-right">
               <a href="{{ route('products.index') }}" class="text-sm text-purple-600 hover:underline font-medium">
                  Selengkapnya →
               </a>
            </div>
         </div>
      </div>
   </div>
</x-dashboard-layout>
