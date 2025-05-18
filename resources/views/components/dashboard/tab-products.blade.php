<div>
   <div class="flex flex-col sm:w-full sm:flex-row sm:justify-between sm:items-center">
      <h2 class="text-2xl font-medium text-gray-900">Daftar Produk</h2>
      <button id="addProductBtn"
         class="py-2 px-4 bg-green-500 border text-white hover:bg-white hover:text-green-700 hover:border-green-700 rounded-md">Tambah
         Produk</button>
   </div>
   <div class="mt-6 overflow-auto">
      <table id="productsTable" class="stripe row-border w-full">
         <thead>
            <tr>
               <th>Nama</th>
               <th>Harga</th>
               <th>Category</th>
               <th>Description</th>
               <th>Image</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($products as $product)
               <tr>
                  <td>{{ $product->name }}</td>
                  <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                  <td>{{ $product->category->name }}</td>
                  <td>{{ $product->description ?? '-' }}</td>
                  <td>
                     @if ($product->image)
                        <a href="{{ asset('storage/' . $product->image) }}" data-lightbox='product-image'>
                           <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                              class="w-16 h-16 object-cover rounded-md">
                        </a>
                     @else
                        <a href="{{ asset('images/no_image.jpeg') }}" data-lightbox='product-image'>
                           <img src="{{ asset('images/no_image.jpeg') }}" alt="Default Image"
                              class="w-16 h-16 object-cover rounded-md">
                        </a>
                     @endif
                  </td>
                  <td>
                     <div class="flex gap-2">
                        <button type="button"
                           class="edit-btn py-2 px-4 bg-blue-500 text-white hover:bg-white hover:text-blue-700 hover:border hover:border-blue-700 rounded-md"
                           data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                           data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                           data-category="{{ $product->category_id }}"
                           data-image="{{ asset('storage/' . $product->image) }}">
                           Edit
                        </button>

                        <button type="button" data-id="{{ $product->id }}"
                           class="delete-btn py-2 px-4 bg-red-500 text-white hover:bg-white hover:text-red-700 hover:border hover:border-red-700 rounded-md">Hapus</button>
                     </div>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
   <div class="bg-white p-6 rounded-md shadow-md">
      <h3 class="text-lg font-medium text-gray-900">Apakah kamu yakin ingin menghapus produk ini?</h3>
      <div class="mt-4 flex justify-end gap-2">
         <button id="cancelDelete" class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
         <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="py-2 px-4 bg-red-500 text-white hover:bg-red-700 rounded-md">Hapus</button>
         </form>
      </div>
   </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
   <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
      <h3 class="text-lg font-medium text-gray-900">Tambah Produk Baru</h3>
      <form id="addProductForm" method="POST" action="{{ route('products.store') }}" class="mt-4"
         enctype="multipart/form-data">
         @csrf
         <div class="mb-4">
            <label for="productName" class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" id="productName" name="name"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required>
         </div>
         <div class="mb-4">
            <label for="productPrice" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" id="productPrice" name="price"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required>
         </div>
         <div class="mb-4">
            <label for="productDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="productDescription" name="description"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" rows="3"></textarea>
         </div>
         <div class="mb-4">
            <label for="productCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="productCategory" name="category_id"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required>
               <option value="" disabled selected>Pilih Kategori</option>
               @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach
            </select>
         </div>
         <div class="mb-4">
            <label for="productImage" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" id="productImage" name="image" accept="image/*"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
         </div>
         <div class="flex justify-end gap-2">
            <button type="button" id="cancelAddProduct"
               class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
            <button type="submit"
               class="py-2 px-4 bg-green-500 text-white hover:bg-green-700 rounded-md">Tambah</button>
         </div>
      </form>
   </div>
</div>

{{-- EDIT MODAL --}}
<div id="editProductModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
   <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
      <h3 class="text-lg font-medium text-gray-900">Edit Produk</h3>
      <form id="editProductForm" method="POST" action="" enctype="multipart/form-data" class="mt-4">
         @csrf
         {{-- @method('PUT') --}}
         <input type="hidden" name="_method" value="PUT">
         <input type="hidden" id="editProductId" name="id">
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" id="editProductName" name="name"
               class="mt-1 block w-full border-gray-300 rounded-md" required>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" id="editProductPrice" name="price"
               class="mt-1 block w-full border-gray-300 rounded-md" required>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="editProductDescription" name="description" rows="3"
               class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="editProductCategory" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md"
               required>
               <option disabled>Pilih Kategori</option>
               @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach
            </select>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Ganti Gambar</label>
            <input type="file" name="image" accept="image/*"
               class="mt-1 block w-full border-gray-300 rounded-md">
         </div>
         <div class="flex justify-end gap-2">
            <button type="button" id="cancelEditProduct"
               class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
            <button type="submit"
               class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded-md">Simpan</button>
         </div>
      </form>
   </div>
</div>


<script>
   $(document).ready(function() {
      const addProductModal = $('#addProductModal');
      const addProductBtn = $('#addProductBtn');
      const cancelAddProduct = $('#cancelAddProduct');

      addProductBtn.on('click', function() {
         addProductModal.removeClass('hidden');
         addProductModal.addClass('flex')
      });

      cancelAddProduct.on('click', function() {
         addProductModal.addClass('hidden');
         addProductModal.removeClass('flex')
      });
   });
</script>

<script>
   $(document).ready(function() {
      $('#productsTable').DataTable({
         columnDefs: [{
            orderable: false,
            targets: -1
         }, {
            orderable: false,
            targets: -2
         }],
         language: {
            emptyTable: "Tidak ada data produk yang tersedia",
         }
      });

      // DELETE MODAL SECTION
      const deleteModal = $('#deleteModal');
      const deleteForm = $('#deleteForm');
      const cancelDelete = $('#cancelDelete');

      $('.delete-btn').on('click', function() {
         const productId = $(this).data('id');
         deleteForm.attr('action', `/dashboard/products/${productId}`);
         deleteModal.removeClass('hidden').addClass('flex');
      });

      cancelDelete.on('click', function() {
         deleteModal.addClass('hidden').removeClass('flex');
      });
      // END DELETE MODAL SECTION

      // EDIT MODAL SECTION
      const editModal = $('#editProductModal');
      const editForm = $('#editProductForm');

      $('.edit-btn').on('click', function() {
         const id = $(this).data('id');
         const name = $(this).data('name');
         const price = $(this).data('price');
         const description = $(this).data('description');
         const category = $(this).data('category');

         $('#editProductName').val(name);
         $('#editProductPrice').val(price);
         $('#editProductDescription').val(description);
         $('#editProductCategory').val(category);

         editForm.attr('action', `/dashboard/products/${id}`);
         editModal.removeClass('hidden').addClass('flex');
      });

      $('#cancelEditProduct').on('click', function() {
         editModal.addClass('hidden').removeClass('flex');
      });
      // END EDIT MODAL SECTION
   });
</script>