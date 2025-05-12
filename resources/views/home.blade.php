<x-app-layout>
   {{-- <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ __('Dashboard') }}
      </h2>
   </x-slot> --}}

   {{-- HERO --}}
   <div class="max-w-7xl mx-auto h-[600px] flex">
      <div class="flex flex-1 flex-col h-full justify-center gap-4">
         <div class="flex flex-col gap-4 justify-center">
            <h1 class="text-yellow-500 text-2xl">Don't panic, Go organice</h1>
            <h2 class="uppercase text-3xl font-extrabold leading-10">Reach For A Healthier You <br> With Organic Foods
            </h2>
            <p class="leading-8 text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus culpa
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
      <div class="flex-1"></div>
   </div>
   {{-- END HERO --}}

   {{-- KATEGORI --}}
   <div class="max-w-7xl mx-auto">
      <p class="text-center text-4xl font-bold">KATEGORI</p>
   </div>
   {{-- END KATEGORI --}}

   {{-- BEST SELLER --}}
   <div class="max-w-7xl mx-auto">
      <p class="text-center text-4xl font-bold">BEST SELLER</p>
   </div>
   {{-- END BEST SELLER --}}
</x-app-layout>
