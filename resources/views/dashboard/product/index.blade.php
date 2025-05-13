<x-dashboard-layout>

   <head>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
   </head>

   <div class="max-w-7xl mx-auto">
      <div class="my-6 p-4 bg-white rounded-md shadow-md">
         <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-4" aria-label="Tabs">
               <button id="tabProducts"
                  class="tab-btn text-blue-600 border-b-2 border-blue-600 px-3 py-2 text-sm font-medium"
                  data-target="productsTab">
                  Daftar Produk
               </button>
               <button id="tabCategories"
                  class="tab-btn text-gray-600 hover:text-blue-600 hover:border-blue-600 border-b-2 border-transparent px-3 py-2 text-sm font-medium"
                  data-target="categoriesTab">
                  Daftar Kategori
               </button>
            </nav>
         </div>

         @include('components.dashboard.tab-products')
         @include('components.dashboard.tab-categories')
      </div>
   </div>

   <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>

   <script>
      $(document).ready(function() {
         // Tab switching logic
         $('.tab-btn').on('click', function() {
            // Reset semua tab ke default
            $('.tab-btn').removeClass('text-blue-600 border-blue-600').addClass(
               'text-gray-600 border-transparent');
            $('.tab-content').addClass('hidden');

            // Aktifkan tab yang diklik
            $(this).removeClass('text-gray-600 border-transparent').addClass('text-blue-600 border-blue-600');
            const target = $(this).data('target');
            $('#' + target).removeClass('hidden');
         });
      });
   </script>
</x-dashboard-layout>
