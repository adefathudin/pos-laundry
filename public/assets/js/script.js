function initApp() {
  const app = {
    db: null,
    time: null,
    activeMenu: 'pos',
    moneys: [2000, 5000, 10000, 20000, 50000, 100000],
    paymentMethod: ['QRIS', 'Cash', 'Transfer'],
    paymentMethodSelected: '',
    products: [],
    keyword: "",
    cart: [],
    cash: 0,
    change: 0,
    dp: 0,
    dpPercent: 0,

    //receipt
    isShowModalReceipt: false,
    receiptNo: null,
    receiptDate: null,

    //customer
    customers: [],
    selectedCustomer: '',
    detailCustomer: [],

    //id
    toko: [],

    test: false,

    async onLoad() {
      this.getProdmast();
      this.getCustomer();
      this.getToko();
      this.qrCodeGenerator('1665928283');
    },

    async getToko() {
      const response = await fetch('http://192.168.0.200:8000/api/toko');
      this.toko = await response.json();
    },

    async getProdmast() {
      const response = await fetch('http://192.168.0.200:8000/api/prodmast');
      const data = await response.json();
      this.products = data.data.products;
    },
    filteredProducts() {
      const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
      return this.products.filter((p) => !rg || p.name.match(rg));
    },
    addToCart(product) {
      const index = this.findCartIndex(product);
      if (index === -1) {
        this.cart.push({
          productId: product.id,
          image: product.kat_id + "-" + product.jenis + ".jpg",
          name: product.nama_produk,
          price: product.price,
          option: product.option,
          qty: 1,
        });
      } else {
        this.cart[index].qty += 1;
      }
      this.beep();
      this.updateChange();
      this.updatePayment();
    },
    findCartIndex(product) {
      return this.cart.findIndex((p) => p.productId === product.id);
    },
    addQty(item, qty) {
      const index = this.cart.findIndex((i) => i.productId === item.productId);
      if (index === -1) {
        return;
      }
      const afterAdd = item.qty + qty;
      if (afterAdd === 0) {
        this.cart.splice(index, 1);
        this.clearSound();
      } else {
        this.cart[index].qty = afterAdd;
        this.beep();
      }
      this.updateChange();
      this.updatePayment();
    },
    addCash(amount) {
      this.cash = (this.cash || 0) + amount;
      this.updateChange();
      this.updatePayment();
      this.beep();
    },
    getItemsCount() {
      return this.cart.reduce((count, item) => count + item.qty, 0);
    },
    updateChange() {
      this.change = this.cash - this.getTotalPrice();
    },
    updatePayment() {
      this.dp = this.cash;
      this.dpPercent = Math.round((this.cash / this.getTotalPrice()) * 100);
    },
    updateCash(value) {
      this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      this.updateChange();
      this.updatePayment();
    },
    getTotalPrice() {
      return this.cart.reduce(
        (total, item) => total + item.qty * item.price,
        0
      );
    },
    getPaymentMethod(method) {
      this.paymentMethodSelected = method;
    },
    submitable() {
      return this.cash > 0 && this.cart.length > 0;
    },
    submit() {
      const time = new Date();
      this.isShowModalReceipt = true;
      this.receiptNo = `${Math.round(time.getTime() / 1000)}`;
      this.receiptDate = this.dateFormat(time);
      this.qrCodeGenerator(this.receiptNo);
    },
    closeModalReceipt() {
      this.isShowModalReceipt = false;
    },
    dateFormat(date) {
      const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'medium' });
      return formatter.format(date);
    },
    numberFormat(number) {
      return (number || "")
        .toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },
    priceFormat(number) {
      return number ? `${this.numberFormat(number)}` : `0`;
    },
    percentFormat(number) {
      return number ? `DP (${(number)}%)` : `DP`;
    },
    qrCodeGenerator(str) {
      JsBarcode('#barcode', str, {
        width: 2,
        height: 40,
        displayValue: false
      });
    },
    clear() {
      this.cash = 0;
      this.cart = [];
      this.receiptNo = null;
      this.receiptDate = null;
      this.updateChange();
      this.updatePayment();
      this.selectedCustomer = 0;
      this.detailCustomer = [];
      this.clearSound();
    },
    clearItem(item) {
      const index = this.cart.findIndex((i) => i.productId === item.productId);
      this.cart.splice(index, 1);
      this.clearSound();
      this.updateChange();
      this.updatePayment();
    },
    beep() {
      this.playSound("assets/sound/beep-29.mp3");
    },
    clearSound() {
      this.playSound("assets/sound/button-21.mp3");
    },
    playSound(src) {
      const sound = new Audio();
      sound.src = src;
      sound.play();
      sound.onended = () => delete (sound);
    },
    printAndProceed() {
      const receiptContent = document.getElementById('receipt-content');
      const titleBefore = document.title;
      const printArea = document.getElementById('print-area');

      printArea.innerHTML = receiptContent.innerHTML;
      document.title = this.receiptNo;

      window.print();
      this.isShowModalReceipt = false;

      printArea.innerHTML = '';
      document.title = titleBefore;

      // TODO save sale data to database

      this.clear();
    },

    //CUSTOMER
    async getCustomer() {
      this.select2 = $(this.$refs.select).select2();
      this.select2.on("select2:select", (event) => {
        this.selectedCustomer = event.target.value;
        this.getDetailCustomer(this.selectedCustomer);
      });
      this.$watch("selectedCustomer", (value) => {
        this.select2.val(value).trigger("change");
      });
      const response = await fetch('http://192.168.0.200:8000/api/customer');
      this.customers = await response.json();
    },
    //get detail customer
    async getDetailCustomer(id) {
      const response = await fetch('http://192.168.0.200:8000/api/customer/' + id);
      this.detailCustomer = await response.json();
    }

  };

  return app;
}
