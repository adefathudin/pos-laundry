<script src="{{ asset('assets/js/barcode.all.min.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
@include('_layouts.header')
@include('_layouts.leftbar')
<!-- page content -->
<div class="flex-grow flex" x-data="initApp()" x-init="onLoad()">
    <div class="flex flex-col bg-blue-gray-50 h-full w-full py-4">
        <div class="flex px-2 flex-row relative">
            <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-cyan-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text"
                class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
                placeholder="Cari produk..." x-model="keyword" />
        </div>
        <div class="h-full overflow-hidden mt-4">
            <div class="h-full overflow-y-auto px-2">
                <!-- <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                    x-show="products.length === 0">
                    <div class="w-full text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        <p class="text-xl">
                            YOU DON'T HAVE
                            <br />
                            ANY PRODUCTS TO SHOW
                        </p>
                    </div>
                </div> -->
                <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                    x-show="filteredProducts().length === 0 && keyword.length > 0">
                    <div class="w-full text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-xl">
                            EMPTY SEARCH RESULT
                            <br />
                            "<span x-text="keyword" class="font-semibold"></span>"
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-6 pb-3">
                    @foreach ($products as $product)
                    <div role="button"
                        class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg"
                        x-on:click="addToCart({{ $product }})">
                        <img src="{{ asset('assets/img/ld-jeans.jpg') }}" alt="" onerror="">
                        <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                            <p class="flex-grow truncate mr-1">{{ $product->name }}</p>
                        </div>
                        <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                            <p class="flex-grow nowrap font-semibold mr-1">{{ $product->price }}</p>
                        </div>
                    </div>
                    <!-- <div class="hidden" x-bind:id="'product-' + {{ $product->id }}" x-data="{
                        id: {{ $product->id }},
                        kat_id: '{{ $product->kat_id }}',
                        jenis: '{{ $product->jenis }}',
                        nama_produk: '{{ $product->nama_produk }}',
                        price: {{ $product->price }},
                        stock: {{ $product->stock }}
                    }"></div> -->
                    @endforeach
                    <!-- <template x-for="product in filteredProducts()" :key="product.id">
                        <div role="button"
                            class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg"
                            :title="product.nama_produk" x-on:click="addToCart(product)">
                            <img x-bind:src="`{{ asset('assets/img/') }}/` + product.kat_id + '-' + product.jenis + '.jpg'"
                                :alt="product.nama_produk" onerror="">
                            <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                                <p class="flex-grow truncate mr-1" x-text="product.nama_produk"></p>
                            </div>
                            <div class="flex pt-3 pb-3 px-3 text-sm -mt-3 text-center">
                                <p class="flex-grow nowrap font-semibold mr-1" x-text="priceFormat(product.price)"></p>
                            </div>
                        </div>
                    </template> -->
                </div>
            </div>
        </div>
    </div>
    <!-- end of store menu -->

    <!-- right sidebar -->
    <div class="w-5/12 flex flex-col bg-blue-gray-50 h-full bg-white pr-4 pl-2 py-4">
        <div class="bg-white rounded-3xl flex flex-col h-full shadow">
            <!-- empty cart -->
            <div x-show="cart.length === 0"
                class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>
                    CART EMPTY
                </p>
            </div>

            <!-- cart items -->
            <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
                <div class="h-16 text-center flex justify-center">
                    <div class="pl-8 text-left text-lg py-4 relative">
                        <!-- cart icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div x-show="getItemsCount() > 0"
                            class="text-center absolute bg-cyan-500 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3"
                            x-text="getItemsCount()"></div>
                    </div>
                    <div class="flex-grow px-8 text-right text-lg py-4 relative">
                        <!-- trash button -->
                        <button x-on:click="clear()" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 w-full px-4 overflow-auto">
                    <template x-for="item in cart" :key="item.productId">
                        <div
                            class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                            <img x-bind:src="`{{ asset('assets/img/') }}/` + item.image" alt=""
                                class="rounded-lg h-10 w-10 bg-white shadow mr-2">
                            <div class="flex-grow">
                                <h5 class="text-sm" x-text="item.name"></h5>
                                <p class="text-xs block" x-text="priceFormat(item.price)"></p>
                            </div>
                            <div class="py-1">
                                <div class="w-44 grid grid-cols-4 gap-4 ml-4">
                                    <button x-on:click="addQty(item, -1)"
                                        class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input x-model.number="item.qty" type="text"
                                        class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm">
                                    <button x-on:click="addQty(item, 1)"
                                        class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                    <button x-on:click="clearItem(item)"
                                        class="py-1 text-blue-gray-600 hover:text-pink-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <!-- end of cart items -->

            <div class="select-none h-auto w-full text-center pb-4 px-4">

                <!-- payment info -->
                <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                    <div>TOTAL</div>
                    <div class="text-right w-full" x-text="priceFormat(getTotalPrice())"></div>
                </div>
                <div class="mb-3 text-blue-gray-700 px-3 pt-2 pb-3 rounded-lg bg-blue-gray-50">
                    <div class="flex text-lg font-semibold">
                        <div class="flex-grow text-left">Pembayaran
                            <span x-show="paymentMethodSelected != ''"
                                x-text="'(' + paymentMethodSelected + ')' "></span>
                        </div>
                        <div class="flex text-right">
                            <div class="mr-2">Rp</div>
                            <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)"
                                type="text"
                                class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none">
                        </div>
                    </div>
                    <!-- <hr class="my-2">
                    <div class="grid grid-cols-3 gap-2 mt-2">
                        <template x-for="money in moneys">
                            <button x-on:click="addCash(money)"
                                class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">+<span
                                    x-text="numberFormat(money)"></span></button>
                        </template>
                    </div> -->
                    <!-- <hr class="my-2">
                    <div class="grid grid-cols-3 gap-2 mt-2">
                        <template x-for="method in paymentMethod">
                            <button x-on:click="getPaymentMethod(method)"
                                class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm"
                                x-text="method"></button>
                        </template>
                    </div> -->
                </div>
                <div x-show="change > 0"
                    class="flex mb-3 text-lg font-semibold bg-cyan-50 text-blue-gray-700 rounded-lg py-2 px-3">
                    <div class="text-cyan-800">KEMBALI</div>
                    <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(change)">
                    </div>
                </div>
                <!-- <div x-show="dpPercent > 0 && dpPercent < 100"
                    class="flex mb-3 text-lg font-semibold bg-cyan-100 text-blue-gray-700 rounded-lg py-2 px-3">
                    <div class="text-cyan-800" x-text="percentFormat(dpPercent)"></div>
                    <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(dp)"></div>
                </div>
                <div x-show="dpPercent > 0 && dpPercent < 100"
                    class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3">
                    <div class="text-cyan-800">SISA</div>
                    <div class="text-right flex-grow text-pink-600" x-text="priceFormat(change)">
                    </div>
                </div> -->
                <div x-show="change == 0 && cart.length > 0"
                    class="flex justify-center mb-3 text-lg font-semibold bg-cyan-50 text-cyan-700 rounded-lg py-2 px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <button class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none" x-bind:class="{
                  'bg-cyan-500 hover:bg-cyan-600': submitable(),
                  'bg-blue-gray-200': !submitable()
                }" :disabled="!submitable()" x-on:click="submit()">
                    SUBMIT
                </button>
                <!-- end of payment info -->


            </div>
        </div>
    </div>
    <!-- end of right sidebar -->
</div>

<!-- modal receipt -->
<div x-show="isShowModalReceipt"
    class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
    <div x-show="isShowModalReceipt" class="fixed glass w-full h-screen left-0 top-0 z-0"
        x-on:click="closeModalReceipt()" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"></div>
    <div x-show="isShowModalReceipt" class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90">
        <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
            <div class="text-center">
                <img src="{{asset ('assets/img/receipt-logo.png') }}" alt="Tailwind POS"
                    class="mb-3 w-8 h-8 inline-block">
                <h2 class="text-xl font-semibold">Indo Laundry</h2>
                <p class="text-sm" x-text="toko.nama_toko +' ('+ toko.nomor_telepon + ')'"></p>
                <p class="text-xs" x-text="toko.alamat"></p>
            </div>
            <hr class="my-2">
            <div class="flex mt-4 text-xs">
                <div class="flex-grow">No: <span x-text="receiptNo"></span></div>
                <div x-text="receiptDate"></div>
            </div>
            <hr class="my-2">
            <div>
                <table class="w-full text-xs">
                    <thead>
                        <tr>
                            <th class="py-1 w-1/12 text-center">#</th>
                            <th class="py-1 text-left">Item</th>
                            <th class="py-1 w-2/12 text-center">Qty</th>
                            <th class="py-1 w-3/12 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in cart" :key="item">
                            <tr>
                                <td class="py-2 text-center" x-text="index+1"></td>
                                <td class="py-2 text-left">
                                    <span x-text="item.name"></span>
                                    <br />
                                    <small x-text="priceFormat(item.price)"></small>
                                </td>
                                <td class="py-2 text-center" x-text="item.qty"></td>
                                <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <hr class="my-2">
            <div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow text-xs">TOTAL</div>
                    <div x-text="priceFormat(getTotalPrice())"></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">TUNAI</div>
                    <div x-text="priceFormat(cash)"></div>
                </div>

                <div class="flex text-xs font-semibold">
                    <div x-show="change >= 0" class="flex-grow">KEMBALI</div>
                    <div x-show="dpPercent > 0 && dpPercent < 100" class="flex-grow">SISA</div>
                    <div x-text="priceFormat(change)"></div>
                </div>

                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">JENIS</div>
                    <div x-text="paymentMethodSelected ? paymentMethodSelected : 'Cash' "></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">STATUS</div>
                    <div x-show="change >= 0">LUNAS</div>
                    <div x-show="dpPercent > 0 && dpPercent < 100" x-text="percentFormat(dpPercent)"></div>
                </div>
            </div>

            <div x-show="selectedCustomer > 0">
                <hr class="my-2">
                <table class="text-xs">
                    <tr>
                        <td colspan="2" class="text-center">Customer</td>
                    </tr>
                    <tr>
                        <td><i class="bi-person"></td>
                        <td x-text="detailCustomer.nama"></td>
                    </tr>
                    <tr>
                        <td><i class="bi-telephone"></td>
                        <td x-text="detailCustomer.nomor_hp"></td>
                    </tr>
                    <tr>
                        <td><i class="bi-geo-alt"></td>
                        <td x-text="detailCustomer.alamat"></td>
                    </tr>
                </table>
            </div>

            <hr class="my-2">
            <div class="text-center">
                <svg class="w-full" id="barcode"></svg>
            </div>
        </div>
        <div class="p-4 w-full">
            <button class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none"
                x-on:click="printAndProceed()">PROCEED</button>
        </div>
    </div>
</div>
<!-- end of noprint-area -->

<div x-show="test" class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
    <div class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalReceipt()"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    <div class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90">
        <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
            <div class="text-center">
                <img src="{{asset ('assets/img/receipt-logo.png') }}" alt="Tailwind POS"
                    class="mb-3 w-8 h-8 inline-block">
                <h2 class="text-xl font-semibold">Indo Laundry</h2>
                <p class="text-sm" x-text="toko.nama_toko +' ('+ toko.nomor_telepon + ')'"></p>
                <p class="text-xs" x-text="toko.alamat"></p>
            </div>

            <hr class="my-2">
            <div class="flex mt-4 text-xs">
                <div class="flex-grow">No: <span x-text="receiptNo"></span></div>
                <div x-text="receiptDate"></div>
            </div>
            <hr class="my-2">
            <div>
                <table class="w-full text-xs">
                    <thead>
                        <tr>
                            <th class="py-1 w-1/12 text-center">#</th>
                            <th class="py-1 text-left">Item</th>
                            <th class="py-1 w-2/12 text-center">Qty</th>
                            <th class="py-1 w-3/12 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in cart" :key="item">
                            <tr>
                                <td class="py-2 text-center" x-text="index+1"></td>
                                <td class="py-2 text-left">
                                    <span x-text="item.name"></span>
                                    <br />
                                    <small x-text="priceFormat(item.price)"></small>
                                </td>
                                <td class="py-2 text-center" x-text="item.qty"></td>
                                <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <hr class="my-2">
            <div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow text-xs">TOTAL</div>
                    <div x-text="priceFormat(getTotalPrice())"></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">TUNAI</div>
                    <div x-text="priceFormat(cash)"></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">KEMBALI</div>
                    <div x-text="priceFormat(change)"></div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">JENIS PEMBAYARAN</div>
                    <div>QRIS</div>
                </div>
                <div class="flex text-xs font-semibold">
                    <div class="flex-grow">STATUS PEMBAYARAN</div>
                    <div>LUNAS</div>
                </div>
            </div>
            <hr class="my-2">
            <div class="text-xs">
                <table class="text-xs">
                    <tr>
                        <td colspan="2" class="text-center">Customer</td>
                    </tr>
                    <tr>
                        <td><i class="bi-person"></td>
                        <td>Ade Fathudin</td>
                    </tr>
                    <tr>
                        <td><i class="bi-telephone"></td>
                        <td>0234234</td>
                    </tr>
                    <tr>
                        <td><i class="bi-geo-alt"></td>
                        <td>Jl. Raya Kp. Sawah No.184, RT.005/RW.002, Jatimurni, Kec. Pd. Melati, Kota Bks, Jawa Barat
                            17431</td>
                    </tr>
                </table>
            </div>

            <hr class="my-2">
            <div class="text-center">
                <svg class="w-full" id="barcode"></svg>
            </div>
        </div>
        <div class="p-4 w-full">
            <button class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none"
                x-on:click="printAndProceed()">PROCEED</button>
        </div>
    </div>
</div>
<div id="print-area" class="print-area"></div>

@include('_layouts.footer')