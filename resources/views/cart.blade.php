<x-app-layout :title="$title">
   <div class="px-4 py-4 xl:px-0">
      <div class="max-w-7xl mx-auto">
         <h1 class="text-2xl font-bold text-gray-800 mb-4">Keranjang Belanja</h1>

         @if ($carts->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
               <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
               <p class="text-gray-600 mb-4">Keranjang belanja Anda kosong</p>
               <a href="{{ route('user.products.index') }}"
                  class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors">
                  <i class="fas fa-arrow-left mr-2"></i> Lanjutkan Belanja
               </a>
            </div>
         @else
            @php
               $subtotal = $carts->sum(function ($item) {
                   return $item->product->price * $item->quantity;
               });
            @endphp
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
               <!-- Cart Items -->
               <div class="lg:col-span-2">
                  <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
                     @foreach ($carts as $item)
                        <div class="p-4 flex flex-col sm:flex-row gap-4">
                           <!-- Product Image -->
                           <div class="w-full sm:w-32 h-32 flex-shrink-0">
                              <img src="{{ asset('storage/' . $item->product->image) }}"
                                 alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-md">
                           </div>

                           <!-- Product Info -->
                           <div class="flex-grow">
                              <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                              <p class="text-gray-600 text-sm mt-1">{{ $item->product->description }}</p>
                              <p class="text-green-600 font-bold mt-2">
                                 Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                           </div>

                           <!-- Quantity Controls -->
                           <div class="flex flex-col items-end">
                              <div class="flex items-center">
                                 <form action="{{ route('cart.decrease', $item->id) }}" method="POST" class="mr-2">
                                    @csrf
                                    <button type="submit"
                                       class="w-8 h-8 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 flex items-center justify-center">
                                       <i class="fas fa-minus text-xs"></i>
                                    </button>
                                 </form>

                                 <span class="w-10 text-center">{{ $item->quantity }}</span>

                                 <form action="{{ route('cart.increase', $item->id) }}" method="POST" class="ml-2">
                                    @csrf
                                    <button type="submit"
                                       class="w-8 h-8 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 flex items-center justify-center">
                                       <i class="fas fa-plus text-xs"></i>
                                    </button>
                                 </form>
                              </div>

                              <!-- Remove Button -->
                              <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-2">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit"
                                    class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                 </button>
                              </form>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>

               <!-- Order Summary -->
               <div class="bg-white rounded-lg shadow p-6 h-fit sticky top-4">
                  <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                  <div class="divide-y divide-gray-200">
                     <div class="pb-3 space-y-3">
                        @foreach ($carts as $item)
                           @php
                              $itemTotal = $item->product->price * $item->quantity;
                           @endphp
                           <div class="flex justify-between text-sm">
                              <span class="text-gray-600">
                                 {{ $item->product->name }} (×{{ $item->quantity }})
                              </span>
                              <span>Rp{{ number_format($itemTotal, 0, ',', '.') }}</span>
                           </div>
                        @endforeach
                     </div>

                     <!-- Calculations -->
                     <div class="py-3">
                        <div class="flex justify-between mb-2">
                           <span class="text-gray-600">Subtotal</span>
                           <span class="font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                     </div>

                     <!-- Total -->
                     <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between font-semibold text-lg">
                           <span>Total</span>
                           <span class="text-green-600">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                     </div>
                  </div>

                  <form action="{{ route('user.orders.store') }}" method="POST" class="mt-4">
                     @csrf
                     <input type="hidden" name="total_amount" value="{{ $subtotal }}">
                     <button type="submit"
                        class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-md font-medium transition-colors">
                        Selesaikan Pesanan
                     </button>
                  </form>

                  <a href="{{ route('user.products.index') }}"
                     class="block text-center text-blue-500 hover:text-blue-700 mt-2 text-sm">
                     <i class="fas fa-arrow-left mr-1"></i> Lanjutkan Belanja
                  </a>
               </div>
            </div>
         @endif
      </div>
   </div>
</x-app-layout>
