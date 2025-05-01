<div class="flex justify-between items-center mb-4">
    <button id="addProductButton" class="bg-cyan-500 text-white px-4 py-2 rounded hover:bg-cyan-600">
        Tambah Produk
    </button>
</div>
<div id="modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <form id="productForm" enctype="multipart/form-data"
        class="max-w-lg mx-auto p-6 bg-white rounded-xl shadow-md space-y-4">
        @csrf

        <h2 class="text-2xl font-bold text-gray-700 mb-4">Tambah Produk</h2>

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
        <div id="previewContainer" class="hidden mt-4">
            <p class="text-sm text-gray-600 mb-2">Preview:</p>
            <img id="previewImage" src="#" alt="Preview" class="w-32 h-32 object-cover rounded-lg shadow border">
        </div>

        <!-- Submit -->
        <button type="button" id="submitBtn"
            class="w-full bg-cyan-600 text-white py-2 rounded-md hover:bg-cyan-700">Simpan</button>
        <button type="button" id="cancelButton"
            class="w-full mt-2 bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Batal</button>
    </form>
    <div id="responseMsg" class="mt-4 text-sm text-green-600 hidden">Form submitted!</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addProductButton = document.getElementById('addProductButton');
        const modal = document.getElementById('modal');
        const cancelButton = document.getElementById('cancelButton');

        addProductButton.addEventListener('click', function () {
            modal.classList.remove('hidden');
        });

        cancelButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    });

    const input = document.getElementById('gambarInput');
    const previewImage = document.getElementById('previewImage');
    const previewContainer = document.getElementById('previewContainer');

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            previewImage.src = '#';
        }
    });

    document.getElementById('submitBtn').addEventListener('click', async function () {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('product.store') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Server error: ' + response.statusText);
            }

            const result = await response.json();
            document.getElementById('responseMsg').classList.remove('hidden');
            document.getElementById('responseMsg').textContent = result.message || 'Form submitted!';

            form.reset();
        } catch (error) {
            console.error('Error:', error);
            alert('Submission failed: ' + error.message);
        }
    });
</script>