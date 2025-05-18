<x-app-layout :title=$title>
   {{-- <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ __('Dashboard') }}
      </h2>
   </x-slot> --}}

   <div class="px-4 xl:px-0">

      {{-- HERO --}}
      <div class="max-w-7xl mx-auto h-[600px] flex">
         <div class="flex flex-1 flex-col h-full justify-center gap-4">
            <div class="flex flex-col gap-4 justify-center">
               <h1 class="text-yellow-500 text-2xl">Don't panic, Go organice</h1>
               <h2 class="uppercase text-3xl font-extrabold leading-10">Reach For A Healthier You <br> With Organic Foods
               </h2>
               <p class="leading-8 text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus
                  culpa
                  officia
                  quasi, accusantium
                  explicabo?</p>
            </div>

            <div>
               <a href="https://g.co/kgs/sdACzZL" target="_blank">
                  <button class="bg-green-500 py-3 px-8 rounded-md text-white text-lg font-semibold">
                     Maps
                  </button>
               </a>
            </div>
         </div>
         <div class="sm:flex-1"></div>
      </div>
      {{-- END HERO --}}

      {{-- KATEGORI --}}
      <div class="max-w-7xl mx-auto">
         <p class="text-center text-4xl font-bold">KATEGORI</p>
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            @foreach ($categories as $category)
               <div class="border border-gray-300 rounded-lg bg-white p-4 shadow-md">
                  <img src="{{ asset('storage/' . $category->img_url) }}" alt="{{ $category->name }}"
                     class="w-full h-48 object-cover rounded-md mb-4">
                  <h3 class="text-xl font-semibold text-gray-800">{{ $category->name }}</h3>
                  <p class="text-gray-600 mt-2">{{ $category->description }}</p>
               </div>
            @endforeach
         </div>
      </div>
      {{-- END KATEGORI --}}

      {{-- BEST SELLER --}}
      <div class="max-w-7xl mx-auto mt-20 pb-8">
         <p class="text-center text-4xl font-bold">BEST SELLER</p>
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach ($best_selling_products as $product)
               <div class="flex flex-col border border-gray-300 rounded-lg bg-white p-4 shadow-md">
                  <div class="h-96 mb-4">
                     <a href="{{ asset('storage/' . $product->image) }}" data-lightbox="best-seller">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                           class="w-full h-full object-cover rounded-md">
                     </a>
                  </div>
                  <div class="flex-1 flex flex-col">
                     <h3 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h3>
                     <p class="text-gray-600 mt-2 flex-1">{{ $product->description }}</p>
                     <p class="text-green-500 font-bold mt-2">Harga: Rp{{ number_format($product->price, 0, ',', '.') }}
                     </p>
                  </div>
                  <form method="POST" action="" class="mt-2">
                     @csrf
                     <div class="flex flex-col sm:flex-row sm:justify-center sm:items-center gap-2">
                        <div class="flex items-center gap-2">
                           <button type="button"
                              class="h-11 py-2 bg-gray-200 text-gray-800 px-4 rounded-md font-semibold decrement-btn">
                              -
                           </button>
                           <input type="text" name="quantity" value="1"
                              oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                              class="h-11 py-2 border border-gray-300 rounded-md px-4 w-20 text-center quantity-input">
                           <button type="button"
                              class="h-11 py-2 bg-gray-200 text-gray-800 px-4 rounded-md font-semibold increment-btn">
                              +
                           </button>
                        </div>
                        <button
                           class="h-11 py-2 flex-1 bg-blue-500 text-center px-4 rounded-md text-white text-sm font-semibold flex items-center justify-center gap-2">
                           <i class="fas fa-shopping-cart"></i>
                           Tambah
                        </button>
                     </div>
                  </form>

               </div>
            @endforeach
         </div>
      </div>
      {{-- END BEST SELLER --}}
   </div>

   <script>
      $(document).ready(function() {
         $('.increment-btn').click(function() {
            let input = $(this).siblings('.quantity-input');
            let currentValue = parseInt(input.val());
            if (!isNaN(currentValue)) {
               input.val(currentValue + 1);
            }
         });

         $('.decrement-btn').click(function() {
            let input = $(this).siblings('.quantity-input');
            let currentValue = parseInt(input.val());
            if (!isNaN(currentValue) && currentValue > 1) {
               input.val(currentValue - 1);
            }
         });
      });
   </script>
</x-app-layout>
