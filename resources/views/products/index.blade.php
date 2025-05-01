@include('_layouts.header')
@include('_layouts.leftbar')

<div class="container mt-4 mx-auto px-4">
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>
        @include('products.section.add_product')
        @include('products.section.list_product')
        @include('products.section.edit_product')
    </div>
</div>

@include('_layouts.footer')