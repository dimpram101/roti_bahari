<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <!-- Scripts -->

   <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
   <div class="min-h-screen bg-gray-100">
      @include('layouts.dashboard-navigation')

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
         @if (session('success'))
            <div class="max-w-7xl mx-auto my-6 p-4 bg-green-100 text-green-700 rounded-md shadow-md relative alert">
               <button class="absolute text-lg top-2 right-2 text-green-700 font-bold close-alert">&times;</button>
               {{ session('success') }}
            </div>
         @endif

         @if (session('error'))
            <div class="max-w-7xl mx-auto my-6 p-4 bg-red-100 text-red-700 rounded-md shadow-md relative alert">
               <button class="absolute text-lg top-2 right-2 text-red-700 font-bold close-alert">&times;</button>
               {{ session('error') }}
            </div>
         @endif

         @if ($errors->any())
            <div class="max-w-7xl mx-auto my-6 p-4 bg-red-100 text-red-700 rounded-md shadow-md relative alert">
               <button class="absolute text-lg top-2 right-2 text-red-700 font-bold close-alert">&times;</button>
               <h3 class="font-medium">Error!</h3>
               <ul>
                  @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
         @endif

         @if (session('message'))
            <div class="max-w-7xl mx-auto my-6 p-4 bg-blue-100 text-blue-700 rounded-md shadow-md">
               {{ session('message') }}
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
