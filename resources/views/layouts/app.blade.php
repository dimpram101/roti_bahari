@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}{{ $title ? ' - ' . $title : '' }}</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   <!-- Di HEAD: hanya CSS -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
   <div class="min-h-screen bg-gray-100">
      @include('layouts.navigation')

      <!-- Page Heading -->
      @isset($header)
         <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
               {{ $header }}
            </div>
         </header>
      @endisset

      <!-- Page Content -->
      <main class="font-rubik">
         @if (!Route::currentRouteName() == 'user.message.create')
            @if (session('error'))
               <div class="max-w-7xl mx-auto mt-4 p-4 bg-red-100 text-red-700 rounded-md shadow-md relative alert">
                  <button class="absolute text-lg top-2 right-2 text-red-700 font-bold close-alert">&times;</button>
                  {{ session('error') }}
               </div>
            @endif

            @if ($errors->any())
               <div class="max-w-7xl mx-auto mt-4 p-4 bg-red-100 text-red-700 rounded-md shadow-md relative alert">
                  <button class="absolute text-lg top-2 right-2 text-red-700 font-bold close-alert">&times;</button>
                  <h3 class="font-medium">Error!</h3>
                  <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
            @endif

         @endif
         
         @if (session('message'))
            <div class="max-w-7xl mx-auto mt-4 p-4 bg-blue-100 text-blue-700 rounded-md shadow-md">
               {{ session('message') }}
            </div>
         @endif

         @if (session('success'))
            <div class="max-w-7xl mx-auto mt-4 p-4 bg-green-100 text-green-700 rounded-md shadow-md relative alert">
               <button class="absolute text-lg top-2 right-2 text-green-700 font-bold close-alert">&times;</button>
               {{ session('success') }}
            </div>
         @endif
         {{ $slot }}
      </main>
   </div>



   <script>
      $(document).ready(function() {
         $('.close-alert').on('click', function() {
            const alertBox = $(this).parent();
            alertBox.fadeOut(500, function() {
               $(this).remove();
            });
         });
      });
   </script>
</body>

</html>
