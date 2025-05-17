@php
   $layout = $user->getRoleNames()[0] == 'admin' ? 'layouts.dashboard' : 'layouts.app';
@endphp
@component($layout)
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 md:px-0 space-y-6">
         <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
               <form method="POST" action="{{ route('profile.updatePicture') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-4">
                     <label for="current_profile_picture" class="block text-sm font-medium text-gray-700">Current Profile
                        Picture</label>
                     <div class="mt-2">
                        @if ($user->image)
                           <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Picture"
                              class="size-28 rounded-full object-cover">
                        @else
                           <img src="{{ asset('images/no_image.jpeg') }}" alt="Profile Picture"
                              class="size-28 rounded-full object-cover">
                        @endif
                     </div>
                  </div>
                  <div class="mb-4">
                     <label for="image" class="block text-sm font-medium text-gray-700">Profile
                        Picture</label>
                     <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                     @error('image')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                     @enderror
                  </div>

                  <div class="flex items-center justify-end">
                     <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Update Picture
                     </button>
                  </div>
               </form>
            </div>
         </div>
         <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
               @include('profile.partials.update-profile-information-form')
            </div>
         </div>

         <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
               @include('profile.partials.update-password-form')
            </div>
         </div>

         <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
               @include('profile.partials.delete-user-form')
            </div>
         </div>
      </div>
   </div>
@endcomponent
