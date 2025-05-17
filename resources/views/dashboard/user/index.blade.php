<x-dashboard-layout>

   <head>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
   </head>

   <div class="max-w-7xl mx-auto">
      <div class="my-6 p-4 bg-white rounded-md shadow-md">
         <div class="border-b border-gray-200 mb-6">
            <div class="flex flex-col sm:w-full sm:flex-row sm:justify-between sm:items-center">
               <h2 class="text-2xl font-medium text-gray-900">Daftar User</h2>
               <button id="addUserBtn"
                  class="py-2 px-4 bg-green-500 border text-white hover:bg-white hover:text-green-700 hover:border-green-700 rounded-md">Tambah
                  User</button>
            </div>
            <div class="mt-6 overflow-auto">
               <table id="usersTable" class="stripe row-border w-full">
                  <thead>
                     <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Image</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($users as $user)
                        <tr>
                           <td>{{ $user->name }}</td>
                           <td>{{ $user->email }}</td>
                           <td>{{ $user->getRoleNames()[0] }}</td>
                           <td>
                              @if ($user->image)
                                 <a href="{{ asset('storage/' . $user->image) }}" data-lightbox="user-image">
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="User Image"
                                       class="w-16 h-16 object-cover rounded-md">
                                 </a>
                              @else
                                 <a href="{{ asset('images/no_image.jpeg') }}" data-lightbox="user-image">
                                    <img src="{{ asset('images/no_image.jpeg') }}" alt="Default Image"
                                       class="w-16 h-16 object-cover rounded-md">
                                 </a>
                              @endif
                           </td>
                           <td>
                              <div class="flex gap-2">
                                 <button type="button"
                                    class="edit-btn py-2 px-4 bg-blue-500 border text-white hover:bg-white hover:text-blue-700 hover:border hover:border-blue-700 rounded-md"
                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}" data-role="{{ $user->getRoleNames()[0] }}"
                                    data-image="{{ asset('storage/' . $user->image) }}">
                                    Edit
                                 </button>

                                 <button type="button" data-id="{{ $user->id }}" @disabled($user->id == auth()->user()->id)
                                    class="delete-btn py-2 px-4 bg-red-500 border text-white hover:bg-white hover:text-red-700 hover:border hover:border-red-700 rounded-md disabled:bg-gray-300 disabled:text-gray-500 disabled:border-gray-300 disabled:cursor-not-allowed">Hapus</button>
                              </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- Delete Confirmation Modal -->
   <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
      <div class="bg-white p-6 rounded-md shadow-md">
         <h3 class="text-lg font-medium text-gray-900">Apakah kamu yakin ingin menghapus user ini?</h3>
         <div class="mt-4 flex justify-end gap-2">
            <button id="cancelDelete"
               class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
            <form id="deleteForm" method="POST" action="">
               @csrf
               @method('DELETE')
               <button type="submit" class="py-2 px-4 bg-red-500 text-white hover:bg-red-700 rounded-md">Hapus</button>
            </form>
         </div>
      </div>
   </div>

   <!-- Add User Modal -->
   <div id="addUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
      <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
         <h3 class="text-lg font-medium text-gray-900">Tambah User Baru</h3>
         <form id="addUserForm" method="POST" action="{{ route('users.store') }}" class="mt-4"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
               <label for="userName" class="block text-sm font-medium text-gray-700">Nama User</label>
               <input type="text" id="userName" name="name"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
            </div>
            <div class="mb-4">
               <label for="userEmail" class="block text-sm font-medium text-gray-700">Email</label>
               <input type="email" id="userEmail" name="email"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
            </div>
            <div class="mb-4">
               <label for="userRole" class="block text-sm font-medium text-gray-700">Role</label>
               <select id="userRole" name="role"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
               </select>
            </div>
            <div class="mb-4">
               <label for="userPassword" class="block text-sm font-medium text-gray-700">Password</label>
               <input type="password" id="userPassword" name="password"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
            </div>
            <div class="mb-4">
               <label for="userImage" class="block text-sm font-medium text-gray-700">Gambar</label>
               <input type="file" id="userImage" name="image" accept="image/*"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>
            <div class="flex justify-end gap-2">
               <button type="button" id="cancelAddUser"
                  class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
               <button type="submit"
                  class="py-2 px-4 bg-green-500 text-white hover:bg-green-700 rounded-md">Tambah</button>
            </div>
         </form>
      </div>
   </div>

   {{-- EDIT MODAL --}}
   <div id="editUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
      <div class="bg-white p-6 rounded-md shadow-md w-full max-w-md">
         <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
         <form id="editUserForm" method="POST" action="" enctype="multipart/form-data" class="mt-4">
            @csrf
            {{-- @method('PUT') --}}
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="editUserId" name="id">
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Nama User</label>
               <input type="text" id="editUserName" name="name"
                  class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Email</label>
               <input type="email" id="editUserEmail" name="email"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
            </div>
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Role</label>
               <select id="editUserRole" name="role"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                  required>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
               </select>
            </div>
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Password</label>
               <input type="password" id="editUserPassword" name="password"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>
            <div class="mb-4">
               <label class="block text-sm font-medium text-gray-700">Ganti Gambar</label>
               <input type="file" name="image" accept="image/*"
                  class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
            <div class="flex justify-end gap-2">
               <button type="button" id="cancelEditUser"
                  class="py-2 px-4 bg-gray-500 text-white hover:bg-gray-700 rounded-md">Batal</button>
               <button type="submit"
                  class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded-md">Simpan</button>
            </div>
         </form>
      </div>
   </div>


   <script>
      $(document).ready(function() {
         const addUserModal = $('#addUserModal');
         const addUserBtn = $('#addUserBtn');
         const cancelAddUser = $('#cancelAddUser');

         addUserBtn.on('click', function() {
            addUserModal.removeClass('hidden');
            addUserModal.addClass('flex')
         });

         cancelAddUser.on('click', function() {
            addUserModal.addClass('hidden');
            addUserModal.removeClass('flex')
         });
      });
   </script>

   <script>
      $(document).ready(function() {
         $('#usersTable').DataTable({
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
            const userId = $(this).data('id');
            deleteForm.attr('action', `/dashboard/users/${userId}`);
            deleteModal.removeClass('hidden').addClass('flex');
         });

         cancelDelete.on('click', function() {
            deleteModal.addClass('hidden').removeClass('flex');
         });
         // END DELETE MODAL SECTION

         // EDIT MODAL SECTION
         const editModal = $('#editUserModal');
         const editForm = $('#editUserForm');

         $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const role = $(this).data('role');

            $('#editUserName').val(name);
            $('#editUserEmail').val(email);
            $('#editUserRole').val(role);

            editForm.attr('action', `/dashboard/users/${id}`);
            editModal.removeClass('hidden').addClass('flex');
         });

         $('#cancelEditUser').on('click', function() {
            editModal.addClass('hidden').removeClass('flex');
         });
         // END EDIT MODAL SECTION
      });
   </script>

   <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
</x-dashboard-layout>
