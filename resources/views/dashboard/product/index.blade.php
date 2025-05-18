<x-dashboard-layout>

   <head>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
   </head>

   <div class="max-w-7xl mx-auto px-4 xl:px-0">
      <div class="my-6 p-4 bg-white rounded-md shadow-md">
         <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-4" aria-label="Tabs">
               <a href="?tab=products"
                  class="tab-btn {{ !array_key_exists('tab', $queries) || (array_key_exists('tab', $queries) && $queries['tab'] == 'products') ? 'text-blue-600 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:border-blue-600' }} border-b-2 px-3 py-2 text-sm font-medium">
                  Daftar Produk
               </a>
               <a href="?tab=categories"
                  class="tab-btn {{ array_key_exists('tab', $queries) && $queries['tab'] == 'categories' ? 'text-blue-600 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:border-blue-600' }} border-b-2 px-3 py-2 text-sm font-medium">
                  Daftar Kategori
               </a>
            </nav>
         </div>

         @if (array_key_exists('tab', $queries))
            @if ($queries['tab'] == 'categories')
               @include('components.dashboard.tab-categories')
            @else
               @include('components.dashboard.tab-products')
            @endif
         @else
            @include('components.dashboard.tab-products')
         @endif
      </div>
   </div>

   <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>

   <script>
      // $(document).ready(function() {
      //    // Tab switching logic
      //    $('.tab-btn').on('click', function() {
      //       // Reset semua tab ke default
      //       $('.tab-btn').removeClass('text-blue-600 border-blue-600').addClass(
      //          'text-gray-600 border-transparent');
      //       $('.tab-content').addClass('hidden');

      //       // Aktifkan tab yang diklik
      //       $(this).removeClass('text-gray-600 border-transparent').addClass('text-blue-600 border-blue-600');
      //       const target = $(this).data('target');
      //       $('#' + target).removeClass('hidden');
      //    });
      // });
   </script>
</x-dashboard-layout>
