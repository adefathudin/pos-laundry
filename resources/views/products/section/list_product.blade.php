<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.tailwindcss.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.tailwindcss.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<table id="productTable" class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
            <th class="border border-gray-300 px-4 py-2">Harga</th>
            <th class="border border-gray-300 px-4 py-2">Stok</th>
            <th class="border border-gray-300 px-4 py-2">Image</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50],
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('product.list') }}",
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "price" },
                { "data": "stock" },
                {
                    "data": "image", "render": function (data, type, row) {
                        return `
                            <img src="/assets/images/products/${data}" alt="${row.name}" class="w-5 h-5 object-cover mx-auto" 
                                onmouseover="this.style.width='100px'; this.style.height='100px';" 
                                onmouseout="this.style.width='20px'; this.style.height='20px';">
                        `;
                    }
                },
                {
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "render": function (data, type, row) {
                        return `
                            <button onclick="editProduct(${row.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm">Edit</button>
                            <button onclick="deleteProduct(${row.id})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-sm">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });


</script>