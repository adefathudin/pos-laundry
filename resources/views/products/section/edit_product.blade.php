<div id="modalEditProduct" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <form id="editProductForm" enctype="multipart/form-data"
        class="max-w-lg mx-2 p-6 bg-white rounded-xl shadow-md space-y-2">
        @csrf
        <div class="flex justify-between space-x-2">
            <div class="text-lg font-semibold text-gray-800 text-center">Edit Produk</div>
            <button onclick="closeModal()" type="button"
                class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">x</button>

        </div>
        <!-- Nama -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
        </div>

        <!-- Harga -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="price" class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
        </div>

        <!-- Stok -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" class="mt-1 w-full rounded-md focus:ring-cyan-500 focus:border-cyan-500">
        </div>

        <!-- Gambar Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
            <input type="file" name="image" id="gambarInput" accept="image/*" class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0 file:text-sm file:font-semibold
                       file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
        </div>
        <!-- Preview -->
        <div id="editPreviewContainer" class="hidden mt-4">
            <p class="text-sm text-gray-600 mb-2">Preview:</p>
            <img id="editPreviewImage" src="#" alt="Preview" class="w-32 h-32 object-cover rounded-lg shadow border">
        </div>

        <!-- Submit -->
        <div class="flex justify-between space-x-2">
            <button type="button" id="submitBtn"
                class="flex-1 bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Simpan</button>
            <button type="button" id="deleteButton"
                class="flex-1 bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Delete</button>
        </div>
    </form>
    <div id="responseMsg" class="mt-4 text-sm text-green-600 hidden">Form submitted!</div>
</div>

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    function editProduct(productId) {
        // Fetch product data and populate the form
        document.getElementById('modalEditProduct').classList.remove('hidden');
        fetch(`{{ route('product.show', '') }}/${productId}`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editProductForm');
                form.querySelector('input[name="name"]').value = data.name;
                form.querySelector('input[name="price"]').value = data.price;
                form.querySelector('input[name="stock"]').value = data.stock;
                const editPreviewImage = form.querySelector('#editPreviewImage');
                editPreviewImage.src = `/assets/images/products/${data.image}`;
                form.querySelector('#editPreviewContainer').classList.remove('hidden');
                form.querySelector('#deleteButton').setAttribute('onclick', `deleteProduct(${productId})`);
            })
            .catch(error => console.error('Error fetching product data:', error));
    }
    document.getElementById('gambarInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const editPreviewImage = document.getElementById('editPreviewImage');
                editPreviewImage.src = e.target.result;
                document.getElementById('editPreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('editPreviewContainer').classList.add('hidden');
        }
    });
    function deleteProduct(productId) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            fetch("{{ route('product.delete') }}", {
                method: 'DELETE',
                body: JSON.stringify({ id: productId }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        $('#productTable').DataTable().ajax.reload();
                    } else {
                        alert('Gagal menghapus produk.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
        }
    }

    function closeModal() {
        document.getElementById('modalEditProduct').classList.add('hidden');
    }
</script>