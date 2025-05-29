<x-app-layout title="Pemesanan">
   <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md mx-auto">
         <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 capitalize">
               PEMESANAN
            </h2>
            <p class="mt-2 text-sm text-amber-600">
               Isi form ini apabila ada yang ingin melakukan pemesanan di hari lain.
            </p>
         </div>

         <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">
               <form class="space-y-6" action="{{ route('user.message.store') }}" method="POST">
                  @csrf
                  <div>
                     <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Pembeli
                     </label>
                     <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                           <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                              fill="currentColor">
                              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                           </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 border-0 bg-amber-50 text-gray-700"
                           placeholder="your@email.com">
                     </div>
                     @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>

                  <div>
                     <label for="phone_number" class="block text-sm font-medium text-gray-700">
                        Nomor Telepon
                     </label>
                     <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                           <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                              fill="currentColor">
                              <path
                                 d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                           </svg>
                        </div>
                        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                           class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 border-0 bg-amber-50 text-gray-700"
                           placeholder="0812xxxxxxxx">
                     </div>
                     @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>

                  <div>
                     <label for="buyer_name" class="block text-sm font-medium text-gray-700">
                        Nama Pembeli
                     </label>
                     <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                           <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                              fill="currentColor">
                              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                 clip-rule="evenodd" />
                           </svg>
                        </div>
                        <input type="text" id="buyer_name" name="buyer_name" required value="{{ old('buyer_name') }}"
                           class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-3 border-0 bg-amber-50 text-gray-700"
                           placeholder="Nama Pembeli">
                     </div>
                     @error('buyer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>

                  <div>
                     <label for="message" class="block text-sm font-medium text-gray-700">
                        Pesanan
                     </label>
                     <div class="mt-1">
                        <textarea id="message" name="message" rows="4" required
                           class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md border-0 bg-amber-50 text-gray-700 p-3"
                           placeholder="Apa yang ingin dipesan?">{{ old('message') }}</textarea>
                     </div>
                     @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                  </div>

                  <div>
                     <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300">
                        Pesan
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                           fill="currentColor">
                           <path fill-rule="evenodd"
                              d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                        </svg>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>