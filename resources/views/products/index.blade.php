<x-app-layout title="Produk">
   <div class="px-4 py-4 xl:px-0">
      <div class="max-w-7xl mx-auto">
         <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Kategori</h2>
         <div class="flex flex-wrap gap-4">
            <a href="{{ route('user.products.index', ['category' => null]) }}"
               class="flex-1 min-w-[150px] border border-gray-300 rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 {{ request('category') === null ? 'bg-green-200' : '' }}">
               <button class="text-center p-4 text-gray-800 hover:text-green-500 font-semibold w-full">
                  <div class="flex flex-col items-center">
                     <span>Semua</span>
                  </div>
               </button>
            </a>
            @foreach ($categories as $category)
               <a href="{{ route('user.products.index', ['category' => $category->id]) }}"
                  class="flex-1 min-w-[150px] border border-gray-300 rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 {{ request('category') == $category->id ? 'bg-green-200' : '' }}">
                  <button class="text-center p-4 text-gray-800 hover:text-green-500 font-semibold w-full">
                     <div class="flex flex-col items-center">
                        <span>{{ $category->name }}</span>
                     </div>
                  </button>
               </a>
            @endforeach
         </div>

         <hr class="my-6 border-2">

         <!-- Enhanced Product Section -->
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            @forelse ($products as $product)
               <div
                  class="flex flex-col border border-gray-200 rounded-lg bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                  <!-- Product Image -->
                  <div class="relative h-64 overflow-hidden">
                     <a href="{{ asset('storage/' . $product->image) }}" data-lightbox="products"
                        data-title="{{ $product->name }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                           class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                     </a>
                  </div>

                  <!-- Product Info -->
                  <div class="p-4 flex-1 flex flex-col">
                     <h3 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-1">{{ $product->name }}</h3>
                     <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>

                     <div class="mt-auto">
                        <p class="text-green-600 font-bold text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}
                        </p>
                     </div>
                  </div>

                  <!-- Add to Cart Section -->
                  <div class="px-4 pb-4">
                     <div class="flex flex-col sm:flex-row sm:items-center gap-2"
                        id="product-form-{{ $product->id }}">
                        <!-- Quantity Controls -->
                        <div class="flex items-center">
                           <button type="button"
                              class="h-10 w-10 bg-gray-100 text-gray-600 rounded-l-md hover:bg-gray-200 transition-colors decrement-btn">
                              <i class="fas fa-minus"></i>
                           </button>
                           <input type="text" name="quantity" value="1"
                              class="h-10 w-12 border-t border-b border-gray-300 text-center quantity-input"
                              oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                           <button type="button"
                              class="h-10 w-10 bg-gray-100 text-gray-600 rounded-r-md hover:bg-gray-200 transition-colors increment-btn">
                              <i class="fas fa-plus"></i>
                           </button>
                        </div>

                        <!-- Add to Cart Button -->
                        <button id="add-to-cart-{{ $product->id }}" data-id="{{ $product->id }}"
                           class="h-10 py-2 flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors flex items-center justify-center gap-2">
                           <i class="fas fa-shopping-cart"></i>
                           <span>Tambah</span>
                        </button>
                     </div>
                  </div>
               </div>
            @empty
               <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center p-6">
                  <p class="text-gray-500">Tidak ada produk yang tersedia.</p>
               </div>
            @endforelse
         </div>
      </div>
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

         // Handle "Tambah" button click
         $('[id^="add-to-cart-"]').click(function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            const quantity = $(this).closest('#product-form-' + productId)
               .find('.quantity-input')

            if (quantity < 1) {
               alert('Jumlah produk tidak boleh kurang dari 1.');
               return;
            }

            const button = $(this);
            button.html('<i class="fas fa-spinner fa-spin"></i> Loading...');
            button.prop('disabled', true);

            $.ajax({
               url: " {{ route('user.carts.store') }}",
               method: 'POST',
               data: {
                  product_id: productId,
                  quantity: quantity.val(),
                  _token: '{{ csrf_token() }}'
               },
               success: function(response) {
                  button.html('<i class="fas fa-check"></i> Added!');
                  setTimeout(function() {
                     button.html('<i class="fas fa-shopping-cart"></i> Tambah');
                     button.prop('disabled', false);
                  }, 1500);

                  quantity.val(1);

                  if (response.cart_count) {
                     $('.cart-count').text(`(${response.cart_count})`);
                  }
               },
               error: function(xhr) {
                  console.error(xhr.responseText);
                  button.html('<i class="fas fa-shopping-cart"></i> Tambah');
                  button.prop('disabled', false);
                  alert('Error adding to cart. Please try again.');
               }
            });
         });
      });
   </script>
</x-app-layout>
