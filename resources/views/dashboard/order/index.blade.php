<x-dashboard-layout title="Penjualan">

   <head>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
      <style>
         .summary-card {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 12px;
            color: white;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
         }

         .summary-card:hover {
            transform: translateY(-5px);
         }

         .summary-title {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0.5rem;
         }

         .summary-value {
            font-size: 1.75rem;
            font-weight: 700;
         }

         .product-list {
            max-height: 120px;
            overflow-y: auto;
            padding-right: 8px;
         }

         .product-list li {
            padding: 4px 0;
            border-bottom: 1px dashed #e5e7eb;
         }

         .product-list li:last-child {
            border-bottom: none;
         }
      </style>
   </head>

   <div class="max-w-7xl mx-auto px-4 xl:px-0">
      <div class="my-6 p-4 bg-white rounded-md shadow-md">
         <div class="border-b border-gray-200 mb-6">
            <h2 class="text-2xl font-medium text-gray-900 mb-6">Daftar Penjualan</h2>

            <form action="{{ route('orders.index') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto mb-2">
               <div class="flex flex-col sm:flex-row gap-3">
                  <select id="monthFilter" name="month"
                     class="border border-gray-300 flex-1 sm:w-36 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                     <option value="all">Semua Bulan</option>
                     @php
                        $currentMonth = request('month') ? request('month') : date('n');
                        $months = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                     @endphp

                     @foreach ($months as $key => $month)
                        <option value="{{ $key }}" {{ $currentMonth == $key ? 'selected' : '' }}>
                           {{ $month }}</option>
                     @endforeach
                  </select>

                  <select id="yearFilter" name="year"
                     class="border border-gray-300 flex-1 sm:w-36 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                     @php
                        $currentYear = request('year') ? request('year') : date('Y');
                     @endphp
                     @for ($year = 2025; $year <= 2030; $year++)
                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                           {{ $year }}</option>
                     @endfor
                  </select>
               </div>

               <button id="filterButton" type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                  Filter
               </button>
            </form>
         </div>

         <!-- Summary Cards -->
         <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="summary-card">
               <div class="summary-title">Total Pesanan</div>
               <div class="summary-value">{{ count($orders) }}</div>
            </div>
            <div class="summary-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
               <div class="summary-title">Total Pendapatan</div>
               <div class="summary-value">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</div>
            </div>
         </div>

         <div class="mt-6 overflow-auto">
            <table id="ordersTable" class="stripe row-border w-full">
               <thead>
                  <tr class="bg-gray-50">
                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        Karyawan</th>
                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Pesanan</th>
                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Daftar Produk</th>
                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                     </th>
                  </tr>
               </thead>
               <tbody class="bg-white divide-y divide-gray-200">
                  @foreach ($orders as $order)
                     <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                           {{ $order->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                           {{ $order->created_at->format('d M Y H:i:s') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                           <ul class="product-list">
                              @foreach ($order->details as $detail)
                                 <li>{{ $detail->product->name }} <span class="text-gray-400">({{ $detail->quantity }}
                                       x
                                       Rp{{ number_format($detail->product->price, 0, ',', '.') }})</span></li>
                              @endforeach
                           </ul>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                           Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                     </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr class="bg-gray-100">
                     <td colspan="3" class="px-6 py-3 text-sm font-semibold text-gray-700 text-right">
                        Total:
                     </td>
                     <td class="px-6 py-3 text-sm font-bold text-blue-700 text-right">
                        Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
   </div>

   <script>
      $(document).ready(function() {
         $('#ordersTable').DataTable({
            columnDefs: [{
               targets: 2,
               orderable: false
            }],
            pageLength: 100,
            language: {
               emptyTable: "Tidak ada data produk yang tersedia",
               infoEmpty: "Menampilkan 0 dari 0 pesanan",
               search: "Cari:",
            },
            dom: '<"flex justify-between items-center mb-4"lf><"bg-white rounded-lg shadow overflow-hidden"t><"flex justify-between items-center mt-4"ip>',
         });
      });
   </script>

   <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
</x-dashboard-layout>
