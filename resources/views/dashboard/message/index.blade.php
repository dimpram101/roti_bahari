<x-dashboard-layout title="Daftar Pesanan">

   <head>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
   </head>

   <div class="max-w-7xl mx-auto px-4 xl:px-0 my-6">
      <div class="bg-white shadow rounded-lg overflow-hidden">
         <!-- Tab Navigation -->
         <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
               <button id="pendingTab"
                  class="tab-btn py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                  Pesanan Proses
               </button>
               <button id="completedTab"
                  class="tab-btn py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                  Pesanan Selesai
               </button>
            </nav>
         </div>

         <!-- Pending Messages Table -->
         <div id="pendingTable" class="p-6">
            <table id="pendingMessagesTable" class="stripe hover" style="width:100%">
               <thead>
                  <tr>
                     <th>Karyawan</th>
                     <th>Nama Pembeli</th>
                     <th>Email</th>
                     <th>Telepon</th>
                     <th>Pesanan</th>
                     <th>Tanggal</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($messages[0] ?? [] as $message)
                     <tr>
                        <td>{{ $message->sender->name ?? '-' }}</td>
                        <td>{{ $message->buyer_name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->phone_number }}</td>
                        <td>{{ $message->message }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                           <div class="flex space-x-2">
                              <form action="{{ route('messages.toggleStatus', $message) }}" method="POST">
                                 @csrf
                                 @method('PUT')
                                 <input type="hidden" name="is_done" value="1">
                                 <input type="hidden" name="query" value="pending">
                                 <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Tandai Selesai
                                 </button>
                              </form>
                              <span class="text-gray-400">|</span>
                              <form action="{{ route('messages.destroy', $message) }}" method="POST">
                                 @csrf
                                 @method('DELETE')
                                 <input type="hidden" name="query" value="pending">
                                 <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                    Hapus
                                 </button>
                              </form>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>

         <!-- Completed Messages Table -->
         <div id="completedTable" class="p-6 hidden">
            <table id="completedMessagesTable" class="stripe hover" style="width:100%">
               <thead>
                  <tr>
                     <th>Karyawan</th>
                     <th>Nama Pembeli</th>
                     <th>Email</th>
                     <th>Telepon</th>
                     <th>Pesanan</th>
                     <th>Tanggal Selesai</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($messages[1] ?? [] as $message)
                     <tr>
                        <td>{{ $message->sender->name ?? '-' }}</td>
                        <td>{{ $message->buyer_name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->phone_number }}</td>
                        <td>{{ $message->message }}</td>
                        <td>{{ $message->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                           <div class="flex space-x-2">
                              <form action="{{ route('messages.toggleStatus', $message) }}" method="POST">
                                 @csrf
                                 @method('PUT')
                                 <input type="hidden" name="is_done" value="0">
                                 <input type="hidden" name="query" value="completed">
                                 <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Tandai Proses
                                 </button>
                              </form>
                              <span class="text-gray-400">|</span>
                              <form action="{{ route('messages.destroy', $message) }}" method="POST">
                                 @csrf
                                 @method('DELETE')
                                 <input type="hidden" name="query" value="completed">
                                 <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                    Hapus
                                 </button>
                              </form>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
   <script>
      $(document).ready(function() {
         $('#pendingMessagesTable').DataTable({
            responsive: true,
            columnDefs: [{
                  responsivePriority: 1,
                  targets: 1
               }, // Nama Pembeli
               {
                  responsivePriority: 2,
                  targets: 4
               }, // Pesanan
               {
                  orderable: false,
                  targets: 6
               } // Aksi
            ]
         });

         $('#completedMessagesTable').DataTable({
            responsive: true,
            columnDefs: [{
                  responsivePriority: 1,
                  targets: 1
               }, // Nama Pembeli
               {
                  responsivePriority: 2,
                  targets: 4
               }, // Pesanan
               {
                  orderable: false,
                  targets: 6
               } // Aksi
            ]
         });

         $('.tab-btn').click(function() {
            const tabId = $(this).attr('id');

            $('.tab-btn').removeClass('border-blue-500 text-blue-600')
               .addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
            $(this).removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300')
               .addClass('border-blue-500 text-blue-600');

            if (tabId === 'pendingTab') {
               $('#pendingTable').removeClass('hidden');
               $('#completedTable').addClass('hidden');
               const url = new URL(window.location.href);
               url.searchParams.set('tab', 'pending');
               window.history.pushState({}, '', url);
            } else {
               $('#pendingTable').addClass('hidden');
               $('#completedTable').removeClass('hidden');
               const url = new URL(window.location.href);
               url.searchParams.set('tab', 'completed');
               window.history.pushState({}, '', url);
            }
         });

         // Set active tab based on query params
         const urlParams = new URLSearchParams(window.location.search);
         console.log(urlParams.get('tab'));
         const activeTab = urlParams.get('tab');
         if (activeTab === 'completed') {
            $('#completedTab').click();
         } else {
            $('#pendingTab').click();
         }
      });
   </script>
</x-dashboard-layout>
