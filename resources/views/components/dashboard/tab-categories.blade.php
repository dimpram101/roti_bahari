<div>
   <div class="flex flex-col sm:w-full sm:flex-row sm:justify-between sm:items-center">
      <h2 class="text-2xl font-medium text-gray-900">Daftar Kategori</h2>
      <button id="addCategoryBtn"
         class="py-2 px-4 bg-green-500 border text-white hover:bg-white hover:text-green-700 hover:border-green-700 rounded-md">Tambah
         Kategori</button>
   </div>
   <div class="mt-6 overflow-auto">
      <table id="categoriesTable" class="stripe row-border w-full">
         <thead>
            <tr>
               <th>Nama Kategori</th>
               <th>Deskripsi</th>
               <th>Gambar</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($categories as $category)
               <tr>
                  <td>{{ $category->name }}</td>
                  <td>{{ $category->description ?? '-' }}</td>
                  <td>
                     @if ($category->img_url)
                        <a href="{{ asset('storage/' . $category->img_url) }}" data-lightbox='category-image'>
                           <img src="{{ asset('storage/' . $category->img_url) }}" alt="Product Image"
                              class="w-16 h-16 object-cover rounded-md">
                        </a>
                     @else
                        <a href="{{ asset('images/no_image.jpeg') }}" data-lightbox='category-image'>
                           <img src="{{ asset('images/no_image.jpeg') }}" alt="Default Image"
                              class="w-16 h-16 object-cover rounded-md">
                        </a>
                     @endif
                  </td>
                  <td>
                     <div class="flex gap-2">
                        <button type="button"
                           class="editCategorybtn py-2 px-4 bg-blue-500 text-white hover:bg-white hover:text-blue-700 hover:border hover:border-blue-700 rounded-md"
                           data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                           data-description="{{ $category->description }}">
                           Edit
                        </button>
                        <button type="button" class="deleteCategoryBtn py-2 px-4 bg-red-500 text-white rounded-md"
                           data-id="{{ $category->id }}">Hapus</button>
                     </div>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="addCategoryModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
   <div class="bg-white rounded-lg shadow-lg">
      <div class="px-6 py-4 border-b">
         <h3 class="text-lg font-medium text-gray-900">Tambah Kategori</h3>
      </div>
      <form id="addCategoryForm" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
         @csrf
         <div class="px-6 py-4">
            <div class="mb-4">
               <label for="categoryName" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
               <input type="text" name="name" id="categoryName"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                  required>
            </div>
            <div class="mb-4">
               <label for="categoryDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
               <textarea name="description" id="categoryDescription" rows="3"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
            </div>
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Gambar</label>
               <input type="file" id="categoryImage" name="image" accept="image/*"
                  class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
         </div>
         <div class="px-6 py-4 border-t flex justify-end">
            <button type="button" id="cancelAddCategoryBtn"
               class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-700">Batal</button>
            <button type="submit"
               class="ml-2 py-2 px-4 bg-green-500 text-white rounded-md hover:bg-green-700">Simpan</button>
         </div>
      </form>
   </div>
</div>

{{-- Delete Category --}}
<div id="deleteCategoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
   <div class="bg-white p-6 rounded-md shadow-md">
      <h3 class="text-lg font-medium text-gray-900">Apakah kamu yakin ingin menghapus kategori ini?</h3>
      <div class="mt-4 flex justify-end gap-2">
         <button id="cancelCategoryDelete"
            class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
         <form id="deleteCategoryForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="py-2 px-4 bg-red-500 text-white hover:bg-red-700 rounded-md">Hapus</button>
         </form>
      </div>
   </div>
</div>

{{-- EDIT MODAL --}}
<div id="editCategoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
   <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
      <h3 class="text-lg font-medium text-gray-900">Edit Produk</h3>
      <form id="editCategoryForm" method="POST" action="" class="mt-4" enctype="multipart/form-data">
         @csrf
         {{-- @method('PUT') --}}
         <input type="hidden" name="_method" value="PUT">
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" id="editCategoryName" name="name"
               class="mt-1 block w-full border-gray-300 rounded-md" required>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="editCategoryDescription" name="description" rows="3"
               class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
         </div>
         <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" id="editCategoryImage" name="image" accept="image/*""
               class="mt-1 block w-full border-gray-300 rounded-md">
         </div>
         <div class="flex justify-end gap-2">
            <button type="button" id="cancelEditCategory"
               class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
            <button type="submit"
               class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded-md">Simpan</button>
         </div>
      </form>
   </div>
</div>

<script>
   $(document).ready(function() {
      $('#categoriesTable').DataTable({
         language: {
            emptyTable: "Tidak ada data kategori yang tersedia",
         }
      });


      $('#addCategoryBtn').on('click', function() {
         $('#addCategoryModal').toggleClass('hidden').toggleClass('flex');
      });

      $('#cancelAddCategoryBtn').on('click', function() {
         $('#addCategoryModal').toggleClass('hidden').toggleClass('flex');
      });

      const deleteModal = $('#deleteCategoryModal');
      const deleteForm = $('#deleteCategoryForm');

      $('.deleteCategoryBtn').on('click', function() {
         const categoryId = $(this).data('id');
         deleteForm.attr('action', `/dashboard/categories/${categoryId}`);
         deleteModal.toggleClass('hidden').toggleClass('flex');
      });

      $('#cancelCategoryDelete').on('click', function() {
         deleteModal.toggleClass('hidden').toggleClass('flex');
      });

      // EDIT MODAL SECTION
      const editModal = $('#editCategoryModal');
      const editForm = $('#editCategoryForm');

      $('.editCategorybtn').on('click', function() {
         const id = $(this).data('id');
         const name = $(this).data('name');
         const price = $(this).data('price');
         const description = $(this).data('description');
         const category = $(this).data('category');

         $('#editCategoryName').val(name);
         $('#editCategoryPrice').val(price);
         $('#editCategoryDescription').val(description);
         $('#editCategoryCategory').val(category);

         editForm.attr('action', `/dashboard/categories/${id}`);
         editModal.removeClass('hidden').addClass('flex');
      });

      $('#cancelEditCategory').on('click', function() {
         editModal.addClass('hidden').removeClass('flex');
      });
   })
</script>
