// Base API URL
const API_BASE_URL = '/api';

// State management - will be populated from API
let state = {
  products: [],
  categories: [],
  brands: [],
  units: [],
  warehouses: [],
  productStocks: [],
  stockMutations: [],
  customers: [],
  suppliers: [],
  purchases: [],
  purchaseItems: [],
  sales: [],
  saleItems: [],
  cashTransactions: []
};

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
  // Initialize Lucide icons
  lucide.createIcons();

  // Load initial data
  loadDashboardData();

  // Set up event listeners for form submissions if needed
  setupFormListeners();
});

// Load all initial data for the dashboard
async function loadDashboardData() {
  try {
    // Load all data in parallel
    const [productsResponse, categoriesResponse, brandsResponse, unitsResponse,
           warehousesResponse, productStocksResponse, stockMutationsResponse,
           customersResponse, suppliersResponse] = await Promise.all([
      fetch(`${API_BASE_URL}/products`),
      fetch(`${API_BASE_URL}/categories`),
      fetch(`${API_BASE_URL}/brands`),
      fetch(`${API_BASE_URL}/units`),
      fetch(`${API_BASE_URL}/warehouses`),
      fetch(`${API_BASE_URL}/product-stocks`),
      fetch(`${API_BASE_URL}/stock-mutations`),
      fetch(`${API_BASE_URL}/customers`),
      fetch(`${API_BASE_URL}/suppliers`)
    ]);

    // Parse responses
    state.products = await productsResponse.json();
    state.categories = await categoriesResponse.json();
    state.brands = await brandsResponse.json();
    state.units = await unitsResponse.json();
    state.warehouses = await warehousesResponse.json();
    state.productStocks = await productStocksResponse.json();
    state.stockMutations = await stockMutationsResponse.json();
    state.customers = await customersResponse.json();
    state.suppliers = await suppliersResponse.json();

    // Render all components
    renderAllComponents();

  } catch (error) {
    console.error('Error loading dashboard data:', error);
    Swal.fire('Error', 'Failed to load data from server', 'error');
  }
}

// Render all components based on current state
function renderAllComponents() {
  renderProducts();
  renderCategories();
  renderBrands();
  renderUnits();
  renderWarehouses();
  renderStockTable();
  renderTransfers();
  renderIncomingStock();
  renderOutgoingStock();
  renderKartuStok();
  renderCustomers();
  renderSuppliers();
  renderPembelian();
  renderKeuanganKas();
  renderDashboard();
  renderPOSCatalog();
  populateSelects();
}

// Product Management Functions
async function renderProducts() {
  try {
    const response = await fetch(`${API_BASE_URL}/products`);
    state.products = await response.json();

    let table = document.getElementById('master-produk-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.products.forEach(p => {
      const productStocks = state.productStocks.filter(ps => ps.product_id === p.id);
      const totalStock = productStocks.reduce((sum, ps) => sum + parseInt(ps.quantity || 0), 0);
      table.innerHTML += `
        <tr>
          <td class="py-4 px-6 font-bold flex items-center gap-3">
            <img src="${p.image || 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80'}" class="w-10 h-10 object-cover rounded-lg border border-cream-dark">
            <div>
              <p class="text-sm font-bold text-zinc-900">${p.name}</p>
              <p class="text-[10px] text-zinc-400">Brand: ${p.brand?.name || '-'}</p>
            </div>
          </td>
          <td class="py-4 px-6 text-zinc-600 font-mono">${p.sku}<p class="text-[10px] text-zinc-400">${p.barcode || '-'}</p></td>
          <td class="py-4 px-6"><span class="px-2 py-0.5 bg-cream-dark text-zinc-700 rounded-full font-semibold text-[10px]">${p.category?.name || '-'}</span></td>
          <td class="py-4 px-6 text-zinc-600">${p.volume || '-'} / <span class="font-bold">${p.unit?.name || '-'}</span></td>
          <td class="py-4 px-6 font-semibold">Rp ${(p.cost_price || 0).toLocaleString('id-ID')}</td>
          <td class="py-4 px-6 font-bold text-zinc-900">
            Rp ${(p.retail_price || 0).toLocaleString('id-ID')}
            <p class="text-[10px] text-zinc-400 font-medium">Grosir: Rp ${(p.wholesale_price || 0).toLocaleString('id-ID')}</p>
          </td>
          <td class="py-4 px-6">
            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">${p.active ? 'Aktif' : 'Tidak Aktif'}</span>
          </td>
          <td class="py-4 px-6 text-right">
            <button onclick="deleteProduct(${p.id})" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
          </td>
        </tr>
      `;
    });

    document.getElementById('master-prod-total-count').innerText = state.products.length;
  } catch (error) {
    console.error('Error rendering products:', error);
  }
}

async function renderCategories() {
  try {
    const response = await fetch(`${API_BASE_URL}/categories`);
    state.categories = await response.json();

    let table = document.getElementById('category-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.categories.forEach(c => {
      // Count products in this category
      const productCount = state.products.filter(p => p.category_id === c.id).length;

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4">${c.name}</td>
          <td class="py-3 px-4">${productCount}</td>
          <td class="py-3 px-4 text-right">
            <button onclick="editCategory(${c.id})" class="text-primary-dark hover:underline font-bold text-xs">Edit</button>
            <button onclick="deleteCategory(${c.id})" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering categories:', error);
  }
}

async function renderBrands() {
  try {
    const response = await fetch(`${API_BASE_URL}/brands`);
    state.brands = await response.json();

    let table = document.getElementById('brand-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.brands.forEach(b => {
      // Count products in this brand
      const productCount = state.products.filter(p => p.brand_id === b.id).length;

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4">${b.name}</td>
          <td class="py-3 px-4">${b.name || '-'}</td>
          <td class="py-3 px-4 text-right">
            <button onclick="editBrand(${b.id})" class="text-primary-dark hover:underline font-bold text-xs">Edit</button>
            <button onclick="deleteBrand(${b.id})" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering brands:', error);
  }
}

async function renderUnits() {
  try {
    const response = await fetch(`${API_BASE_URL}/units`);
    state.units = await response.json();

    let table = document.getElementById('unit-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.units.forEach(u => {
      table.innerHTML += `
        <tr>
          <td class="py-3 px-4">${u.name}</td>
          <td class="py-3 px-4">${u.name || '-'}</td>
          <td class="py-3 px-4 text-right">
            <button onclick="editUnit(${u.id})" class="text-primary-dark hover:underline font-bold text-xs">Edit</button>
            <button onclick="deleteUnit(${u.id})" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering units:', error);
  }
}

// Warehouse Management Functions
async function renderWarehouses() {
  try {
    const response = await fetch(`${API_BASE_URL}/warehouses`);
    state.warehouses = await response.json();

    let container = document.getElementById('warehouse-grid');
    if (!container) return;

    container.innerHTML = '';
    state.warehouses.forEach(w => {
      container.innerHTML += `
        <div class="bg-white border border-cream-dark p-5 rounded-2xl shadow-sm space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-zinc-400 font-mono">${w.code}</span>
            <i data-lucide="home" class="w-5 h-5 text-primary-dark"></i>
          </div>
          <h3 class="font-extrabold text-base">${w.name}</h3>
          <p class="text-xs text-zinc-500">${w.address}</p>
          <div class="border-t border-cream-dark pt-3 text-xs flex justify-between text-zinc-500 font-semibold">
            <span>PIC: ${w.name}</span>
            <span class="text-green-600">Online</span>
          </div>
        </div>
      `;
    });
    lucide.createIcons();
  } catch (error) {
    console.error('Error rendering warehouses:', error);
  }
}

async function renderStockTable() {
  try {
    const response = await fetch(`${API_BASE_URL}/product-stocks`);
    state.productStocks = await response.json();

    const table = document.getElementById('realtime-stock-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.productStocks.forEach(ps => {
      const product = state.products.find(p => p.id === ps.product_id) || { name: '-', sku: '-' };
      const warehouse = state.warehouses.find(w => w.id === ps.warehouse_id) || { name: '-' };
      const productCategory = product.category?.name || '';
      const safetyLimit = productCategory === 'Galon' ? 10 : 30;
      const reorderPoint = Math.round(safetyLimit * 1.5);
      const unitName = product.unit?.name || '';
      const sku = String(product.sku || '').replace(/'/g, "\\'");
      const warehouseName = String(warehouse.name || '').replace(/'/g, "\\'");

      let shortage;
      if (ps.quantity <= safetyLimit) {
        shortage = '<span class="text-red-600 font-bold">Stok Kritis</span>';
      } else if (ps.quantity <= reorderPoint) {
        shortage = '<span class="text-yellow-600 font-semibold">Butuh Reorder</span>';
      } else {
        shortage = '<span class="text-green-600">Cukup</span>';
      }

      table.innerHTML += `
        <tr class="hover:bg-cream/10">
          <td class="py-3 px-4 font-bold text-zinc-900">${product.name}<p class="text-[10px] text-zinc-400">${product.sku}</p></td>
          <td class="py-3 px-4 text-zinc-600">${warehouse.name}</td>
          <td class="py-3 px-4 font-black">${ps.quantity} ${unitName}</td>
          <td class="py-3 px-4 text-zinc-500">${safetyLimit} ${unitName}</td>
          <td class="py-3 px-4 text-zinc-500">${reorderPoint} ${unitName}</td>
          <td class="py-3 px-4">${shortage}</td>
          <td class="py-3 px-4 text-right">
            <button onclick="adjustStockSim('${sku}', '${warehouseName}')" class="text-primary-dark hover:underline font-bold">Adjust</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering stock table:', error);
  }
}

// Stock Mutation Functions
async function renderTransfers() {
  try {
    const response = await fetch(`${API_BASE_URL}/stock-mutations?type=transfer`);
    const transfers = await response.json();

    let table = document.getElementById('transfer-stock-table-body');
    if (!table) return;

    table.innerHTML = '';
    transfers.forEach(tf => {
      const product = state.products.find(p => p.id === tf.product_id) || { name: '-' };
      const fromWarehouse = state.warehouses.find(w => w.id === tf.from_warehouse_id) || { name: '-' };
      const toWarehouse = state.warehouses.find(w => w.id === tf.to_warehouse_id) || { name: '-' };

      const statusBadge = tf.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                         (tf.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100');

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-mono font-bold">${tf.id}</td>
          <td class="py-3 px-4">${fromWarehouse.name}</td>
          <td class="py-3 px-4">${toWarehouse.name}</td>
          <td class="py-3 px-4 font-semibold">${product.name} (x${tf.quantity})</td>
          <td class="py-3 px-4 text-zinc-500">${tf.created_at?.split('T')[0] || '-'}</td>
          <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold ${statusBadge}">${tf.status}</span></td>
          <td class="py-3 px-4 text-right">
            ${tf.status === 'pending' ? `<button onclick="approveTransfer(${tf.id})" class="bg-primary px-3 py-1 rounded font-bold text-[10px] text-zinc-900">Approve</button>` : '<span class="text-zinc-400">Selesai</span>'}
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering transfers:', error);
  }
}

async function renderIncomingStock() {
  try {
    const response = await fetch(`${API_BASE_URL}/stock-mutations?type=incoming`);
    const incoming = await response.json();

    let table = document.getElementById('incoming-stock-table-body');
    if (!table) return;

    table.innerHTML = '';
    incoming.forEach(item => {
      const product = state.products.find(p => p.id === item.product_id) || { name: '-' };
      const warehouse = state.warehouses.find(w => w.id === item.warehouse_id) || { name: '-' };

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-mono font-bold">IN-${item.id.toString().padStart(4, '0')}</td>
          <td class="py-3 px-4">${item.created_at?.split('T')[0] || '-'}</td>
          <td class="py-3 px-4">${warehouse.name}</td>
          <td class="py-3 px-4">${item.reference_type || 'Pembelian'}</td>
          <td class="py-3 px-4">${product.name} (${item.quantity} ${product.unit?.name || ''})</td>
          <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-[10px]">Diterima</span></td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering incoming stock:', error);
  }
}

async function renderOutgoingStock() {
  try {
    const response = await fetch(`${API_BASE_URL}/stock-mutations?type=outgoing`);
    const outgoing = await response.json();

    let table = document.getElementById('outgoing-stock-table-body');
    if (!table) return;

    table.innerHTML = '';
    outgoing.forEach(item => {
      const product = state.products.find(p => p.id === item.product_id) || { name: '-' };
      const warehouse = state.warehouses.find(w => w.id === item.warehouse_id) || { name: '-' };

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-mono font-bold">OUT-${item.id.toString().padStart(4, '0')}</td>
          <td class="py-3 px-4">${item.created_at?.split('T')[0] || '-'}</td>
          <td class="py-3 px-4">${warehouse.name}</td>
          <td class="py-3 px-4">${item.reference_type || 'Penjualan'}</td>
          <td class="py-3 px-4">${product.name} (${item.quantity} ${product.unit?.name || ''})</td>
          <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold text-[10px]">Dikirim</span></td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering outgoing stock:', error);
  }
}

async function renderKartuStok() {
  try {
    const response = await fetch(`${API_BASE_URL}/stock-mutations`);
    const mutations = await response.json();

    let table = document.getElementById('kartu-stok-table-body');
    if (!table) return;

    table.innerHTML = '';
    // Sort by date descending
    const sortedMutations = [...mutations].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    sortedMutations.forEach(m => {
      const product = state.products.find(p => p.id === m.product_id) || { name: '-', sku: '' };
      const warehouse = state.warehouses.find(w => w.id === m.warehouse_id) || { name: '-' };

      const qtyIn = m.transaction_type === 'in' ? m.quantity : 0;
      const qtyOut = m.transaction_type === 'out' ? m.quantity : 0;

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 text-zinc-500">${m.created_at?.substring(0, 16).replace('T', ' ') || '-'}</td>
          <td class="py-3 px-4">${warehouse.name}</td>
          <td class="py-3 px-4 font-bold">${product.name} (${product.sku})</td>
          <td class="py-3 px-4">${m.reference_type || '-'}</td>
          <td class="py-3 px-4 text-center">${qtyIn > 0 ? qtyIn : '-'}</td>
          <td class="py-3 px-4 text-center">${qtyOut > 0 ? qtyOut : '-'}</td>
          <td class="py-3 px-4 text-right font-bold">0</td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering kartu stok:', error);
  }
}

// Customer Management Functions
async function renderCustomers() {
  try {
    const response = await fetch(`${API_BASE_URL}/customers`);
    state.customers = await response.json();

    let table = document.getElementById('customer-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.customers.forEach(c => {
      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-bold">${c.name}</td>
          <td class="py-3 px-4"><span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded font-semibold text-[10px]">${c.type}</span></td>
          <td class="py-3 px-4 font-mono">${c.phone || '-'}</td>
          <td class="py-3 px-4 text-zinc-500">${c.address || '-'}</td>
          <td class="py-3 px-4 font-semibold">Rp ${(c.credit_limit || 0).toLocaleString('id-ID')}</td>
          <td class="py-3 px-4 font-bold ${(c.credit_limit || 0) > 0 ? 'text-red-500' : 'text-green-600'}">Rp 0</td>
          <td class="py-3 px-4 text-right">
            <button onclick="Swal.fire('Riwayat Belanja', 'Riwayat pembelian customer ini akan ditarik dari database di backend.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Riwayat</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering customers:', error);
  }
}

// Supplier Management Functions
async function renderSuppliers() {
  try {
    const response = await fetch(`${API_BASE_URL}/suppliers`);
    state.suppliers = await response.json();

    let table = document.getElementById('supplier-table-body');
    if (!table) return;

    table.innerHTML = '';
    state.suppliers.forEach(s => {
      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-bold">${s.name}</td>
          <td class="py-3 px-4 font-semibold text-zinc-600">${s.contact_person || '-'}</td>
          <td class="py-3 px-4 font-mono">${s.phone || '-'}</td>
          <td class="py-3 px-4 text-zinc-500">${s.address || '-'}</td>
          <td class="py-3 px-4 font-semibold">Rp 0</td>
          <td class="py-3 px-4 font-bold text-red-500">Rp 0</td>
          <td class="py-3 px-4 text-right">
            <button onclick="Swal.fire('Riwayat Transaksi', 'Menampilkan invoice pembelian dari supplier.', 'info')" class="text-primary-dark hover:underline font-bold text-xs">Transaksi</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering suppliers:', error);
  }
}

// Purchase Management Functions
async function renderPembelian() {
  try {
    const response = await fetch(`${API_BASE_URL}/purchases`);
    const purchases = await response.json();

    let table = document.getElementById('po-table-body');
    if (!table) return;

    table.innerHTML = '';
    purchases.forEach(p => {
      const statusBadge = p.status === 'completed' ? 'bg-green-100 text-green-800' :
                         (p.status === 'pending' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100');

      table.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-mono font-bold">${p.invoice_number}</td>
          <td class="py-3 px-3 px-4 font-semibold">${p.supplier?.name || '-'}</td>
          <td class="py-3 px-4 text-zinc-500">${p.purchase_date?.split('T')[0] || '-'}</td>
          <td class="py-3 px-4 text-zinc-600">${p.items?.length > 0 ? p.items.map(i => `${i.product?.name} (${i.quantity})`).join(', ') : '-'}</td>
          <td class="py-3 px-4 font-extrabold">Rp ${(p.total_amount || 0).toLocaleString('id-ID')}</td>
          <td class="py-3 px-4"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${statusBadge}">${p.status}</span></td>
          <td class="py-3 px-4 text-right">
            ${p.status === 'pending' ? `<button onclick="receiveGoodsSim('${p.invoice_number}')" class="bg-primary text-[10px] font-bold px-3 py-1 rounded">Terima Barang</button>` : '<span class="text-zinc-400">Diterima</span>'}
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering purchases:', error);
  }
}

// Financial Functions
async function renderKeuanganKas() {
  try {
    // In a real app, this would come from a cash transactions endpoint
    // For now, we'll simulate with empty data since we don't have a specific cash transaction endpoint
    let table = document.getElementById('keu-kas-table-body');
    if (!table) return;

    table.innerHTML = `
      <tr>
        <td colspan="6" class="py-4 text-center text-zinc-500">Belum ada transaksi kas</td>
      </tr>
    `;
  } catch (error) {
    console.error('Error rendering kas:', error);
  }
}

// Dashboard Functions
async function renderDashboard() {
  try {
    // Get low stock products
    const lowStockProducts = [];

    state.products.forEach(product => {
      Object.keys(product.stock || {}).forEach(warehouseId => {
        const quantity = product.stock[warehouseId] || 0;
        const warehouse = state.warehouses.find(w => w.id === parseInt(warehouseId)) || { name: 'Unknown' };
        const safetyLimit = product.category?.name === 'Galon' ? 10 : 30;
        const reorderPoint = safetyLimit * 1.5;

        if (quantity <= reorderPoint) {
          lowStockProducts.push({
            name: product.name,
            sku: product.sku,
            warehouse: warehouse.name,
            qty: quantity,
            safety: safetyLimit,
            rop: reorderPoint,
            status: quantity <= safetyLimit ? 'KRITIS' : 'Reorder Point'
          });
        }
      });
    });

    let tableBody = document.getElementById('dash-min-stock-table-body');
    if (!tableBody) return;

    tableBody.innerHTML = '';
    lowStockProducts.forEach(item => {
      const badgeClass = item.status === 'KRITIS' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-800';
      tableBody.innerHTML += `
        <tr>
          <td class="py-3 px-4 font-bold">${item.name}<p class="text-[10px] text-zinc-400 font-medium">${item.sku}</p></td>
          <td class="py-3 px-4 text-zinc-500">${item.warehouse}</td>
          <td class="py-3 px-4 font-extrabod text-sm">${item.qty} Pcs</td>
          <td class="py-3 px-4 text-zinc-500">${item.safety} Pcs</td>
          <td class="py-3 px-4 text-zinc-500">${item.rop} Pcs</td>
          <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold ${badgeClass}">${item.status}</span></td>
          <td class="py-3 px-4 text-right">
            <button onclick="orderStockSim('${item.name}')" class="bg-primary hover:bg-primary-dark font-bold text-[10px] px-2 py-1 rounded">Reorder</button>
          </td>
        </tr>
      `;
    });
  } catch (error) {
    console.error('Error rendering dashboard:', error);
  }
}

// POS Functions
function renderPOSCatalog() {
  try {
    let grid = document.getElementById('pos-catalog-grid');
    if (!grid) return;

    grid.innerHTML = '';
    state.products.filter(p => p.active).forEach(p => {
      const productStocks = state.productStocks.filter(ps => ps.product_id === p.id);
      let totalStock = productStocks.reduce((sum, ps) => sum + parseInt(ps.quantity || 0), 0);
      let iconName = 'package';
      if (p.category?.name?.toLowerCase() === 'galon') iconName = 'droplet';
      else if (p.category?.name?.toLowerCase() === 'botol') iconName = 'glass-water';
      else if (p.category?.name?.toLowerCase() === 'gelas') iconName = 'cup-soda';

      grid.innerHTML += `
        <div onclick="addToPOSCart(${p.id})" class="bg-white border border-cream-dark p-3 rounded-2xl cursor-pointer hover:shadow-md hover:scale-[1.02] active:scale-95 transition-all flex flex-col justify-between h-full">
          <div class="w-full aspect-square bg-white border border-cream-dark/30 rounded-xl mb-2 relative overflow-hidden flex items-center justify-center shrink-0">
            <img src="${p.image || 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80'}" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');" class="w-full h-full object-contain p-2">
            <div class="hidden absolute inset-0 bg-primary-light/30 flex flex-col items-center justify-center text-primary-dark/80">
              <i data-lucide="${iconName}" class="w-8 h-8 fill-primary/10"></i>
            </div>
          </div>
          <div class="flex-1 flex flex-col justify-between min-h-0">
            <div class="space-y-0.5">
              <span class="text-[9px] uppercase font-bold text-zinc-400 block">${p.category?.name || ''}</span>
              <h4 class="font-bold text-xs leading-tight text-zinc-950 truncate" title="${p.name}">${p.name}</h4>
            </div>
            <div class="flex items-end justify-between mt-2 pt-2 border-t border-cream-dark/50">
              <span class="font-black text-sm text-zinc-900">Rp ${(p.retail_price || 0).toLocaleString('id-ID')}</span>
              <span class="text-[10px] font-bold ${totalStock <= 15 ? 'text-red-500 bg-red-50 px-1.5 py-0.5 rounded' : 'text-zinc-500'}">Stok: ${totalStock}</span>
            </div>
          </div>
        </div>
      `;
    });
    lucide.createIcons();
  } catch (error) {
    console.error('Error rendering POS catalog:', error);
  }
}

// Cart Functions (keeping local state for POS cart)
let posCart = [];
let activePaymentMethod = 'Tunai';

function addToPOSCart(prodId) {
  let product = state.products.find(p => p.id === prodId);
  let existing = posCart.find(item => item.product.id === prodId);

  if (existing) {
    existing.qty += 1;
  } else {
    posCart.push({ product: product, qty: 1 });
  }

  recalculatePOSCartTotal();
  renderPOSCart();
}

function changeCartQty(index, amt) {
  posCart[index].qty += amt;
  if (posCart[index].qty <= 0) {
    posCart.splice(index, 1);
  }
  recalculatePOSCartTotal();
  renderPOSCart();
}

function recalculatePOSCartTotal() {
  let subtotal = 0;
  let custIdx = document.getElementById('pos-customer-select') ? parseInt(document.getElementById('pos-customer-select').value) : 0;
  let customerType = state.customers[custIdx]?.type || 'Retail';

  posCart.forEach(item => {
    let price = item.product.retail_price || 0;
    if (customerType === 'Agen') {
      price = item.product.agency_price || item.product.retail_price * 0.9;
    } else if (customerType === 'Distributor') {
      price = item.product.wholesale_price || item.product.retail_price * 0.8;
    }
    subtotal += price * item.qty;
  });

  let discountPct = parseFloat(document.getElementById('pos-discount-input')?.value || 0) || 0;
  let discountValue = (discountPct / 100) * subtotal;
  let finalTotal = subtotal - discountValue;

  if (document.getElementById('pos-cart-subtotal')) {
    document.getElementById('pos-cart-subtotal').innerText = 'Rp ' + Math.round(subtotal).toLocaleString('id-ID');
  }
  if (document.getElementById('pos-cart-discount-value')) {
    document.getElementById('pos-cart-discount-value').innerText = '- Rp ' + Math.round(discountValue).toLocaleString('id-ID');
  }
  if (document.getElementById('pos-cart-total-display')) {
    document.getElementById('pos-cart-total-display').innerText = 'Rp ' + Math.round(finalTotal).toLocaleString('id-ID');
  }
  if (document.getElementById('payment-modal-total')) {
    document.getElementById('payment-modal-total').innerText = 'Rp ' + Math.round(finalTotal).toLocaleString('id-ID');
  }
}

function renderPOSCart() {
  let container = document.getElementById('pos-cart-items');
  if (!container) return;

  container.innerHTML = '';

  if (posCart.length === 0) {
    container.innerHTML = `
      <div class="h-full flex flex-col items-center justify-center text-zinc-400 py-12">
        <i data-lucide="shopping-cart" class="w-8 h-8 mb-2 opacity-50"></i>
        <p class="text-xs">Keranjang Belanja Kosong</p>
      </div>
    `;
    lucide.createIcons();
    return;
  }

  let custIdx = document.getElementById('pos-customer-select') ? parseInt(document.getElementById('pos-customer-select').value) : 0;
  let customerType = state.customers[custIdx]?.type || 'Retail';

  posCart.forEach((item, idx) => {
    let price = item.product.retail_price || 0;
    if (customerType === 'Agen') price = item.product.agency_price || item.product.retail_price * 0.9;
    if (customerType === 'Distributor') price = item.product.wholesale_price || item.product.retail_price * 0.8;

    container.innerHTML += `
      <div class="bg-white border border-cream-dark p-3 rounded-xl flex items-center justify-between shadow-sm">
        <div>
          <h5 class="font-bold text-xs">${item.product.name}</h5>
          <p class="text-[10px] text-zinc-500">Rp ${(price || 0).toLocaleString('id-ID')} / ${item.product.unit?.name || ''}</p>
        </div>
        <div class="flex items-center gap-2">
          <button onclick="changeCartQty(${idx}, -1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">-</button>
          <span class="text-xs font-bold w-6 text-center">${item.qty}</span>
          <button onclick="changeCartQty(${idx}, 1)" class="w-6 h-6 bg-cream hover:bg-cream-dark text-zinc-800 rounded flex items-center justify-center font-bold text-xs">+</button>
        </div>
      </div>
    `;
  });
  lucide.createIcons();
}

function clearPOSCart() {
  posCart = [];
  recalculatePOSCartTotal();
  renderPOSCart();
}

// Form Handler Functions
function setupFormListeners() {
  // Product Form
  const productForm = document.getElementById('add-product-form');
  if (productForm) {
    productForm.addEventListener('submit', saveProduct);
  }

  // Category Form
  const categoryForm = document.getElementById('add-category-form');
  if (categoryForm) {
    categoryForm.addEventListener('submit', saveCategory);
  }

  // Brand Form
  const brandForm = document.getElementById('add-brand-form');
  if (brandForm) {
    brandForm.addEventListener('submit', saveBrand);
  }

  // Unit Form
  const unitForm = document.getElementById('add-unit-form');
  if (unitForm) {
    unitForm.addEventListener('submit', saveUnit);
  }

  // Warehouse Form
  const warehouseForm = document.getElementById('add-warehouse-form');
  if (warehouseForm) {
    warehouseForm.addEventListener('submit', saveWarehouse);
  }
}

// Product CRUD Functions
async function saveProduct(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      name: formData.get('name'),
      sku: formData.get('sku'),
      barcode: formData.get('barcode'),
      category_id: parseInt(formData.get('category_id')),
      brand_id: parseInt(formData.get('brand_id')),
      unit_id: parseInt(formData.get('unit_id')),
      volume: formData.get('volume'),
      cost_price: parseFloat(formData.get('cost_price')),
      retail_price: parseFloat(formData.get('retail_price')),
      wholesale_price: parseFloat(formData.get('wholesale_price')),
      agency_price: parseFloat(formData.get('agency_price')) || null,
      active: formData.get('active') === 'on',
      image: formData.get('image') || 'https://images.unsplash.com/photo-1523362628745-0c100150b504?auto=format&fit=crop&w=300&q=80'
    };

    const response = await fetch(`${API_BASE_URL}/products`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const newProduct = await response.json();

    // Close modal
    const modal = document.getElementById('add-product-modal');
    if (modal) {
      modal.classList.add('hidden');
    }

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Produk Baru berhasil disimpan!', 'success');
  } catch (error) {
    console.error('Error saving product:', error);
    Swal.fire('Error', 'Gagal menyimpan produk', 'error');
  }
}

async function deleteProduct(id) {
  if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/products/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Produk berhasil dihapus!', 'success');
  } catch (error) {
    console.error('Error deleting product:', error);
    Swal.fire('Error', 'Gagal menghapus produk', 'error');
  }
}

// Category CRUD Functions
async function saveCategory(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      name: formData.get('name')
    };

    const response = await fetch(`${API_BASE_URL}/categories`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Close modal (assuming there's a category modal)
    const modal = document.getElementById('add-category-modal');
    if (modal) {
      modal.classList.add('hidden');
    }

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Kategori berhasil disimpan!', 'success');
  } catch (error) {
    console.error('Error saving category:', error);
    Swal.fire('Error', 'Gagal menyimpan kategori', 'error');
  }
}

async function deleteCategory(id) {
  if (!confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/categories/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Kategori berhasil dihapus!', 'success');
  } catch (error) {
    console.error('Error deleting category:', error);
    Swal.fire('Error', 'Gagal menghapus kategori', 'error');
  }
}

// Brand CRUD Functions
async function saveBrand(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      name: formData.get('name')
    };

    const response = await fetch(`${API_BASE_URL}/brands`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Close modal
    const modal = document.getElementById('add-brand-modal');
    if (modal) {
      modal.classList.add('hidden');
    }

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Brand berhasil disimpan!', 'success');
  } catch (error) {
    console.error('Error saving brand:', error);
    Swal.fire('Error', 'Gagal menyimpan brand', 'error');
  }
}

async function deleteBrand(id) {
  if (!confirm('Apakah Anda yakin ingin menghapus brand ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/brands/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Brand berhasil dihapus!', 'success');
  } catch (error) {
    console.error('Error deleting brand:', error);
    Swal.fire('Error', 'Gagal menghapus brand', 'error');
  }
}

// Unit CRUD Functions
async function saveUnit(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      name: formData.get('name'),
      symbol: formData.get('symbol')
    };

    const response = await fetch(`${API_BASE_URL}/units`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Close modal
    const modal = document.getElementById('add-unit-modal');
    if (modal) {
      modal.classList.add('hidden');
    }

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Satuan berhasil disimpan!', 'success');
  } catch (error) {
    console.error('Error saving unit:', error);
    Swal.fire('Error', 'Gagal menyimpan satuan', 'error');
  }
}

async function deleteUnit(id) {
  if (!confirm('Apakah Anda yakin ingin menghapus satuan ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/units/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Satuan berhasil dihapus!', 'success');
  } catch (error) {
    console.error('Error deleting unit:', error);
    Swal.fire('Error', 'Gagal menyimpan satuan', 'error');
  }
}

// Warehouse CRUD Functions
async function saveWarehouse(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      name: formData.get('name'),
      code: formData.get('code'),
      address: formData.get('address'),
      is_active: formData.get('is_active') === 'on'
    };

    const response = await fetch(`${API_BASE_URL}/warehouses`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Close modal
    const modal = document.getElementById('add-warehouse-modal');
    if (modal) {
      modal.classList.add('hidden');
    }

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Gudang berhasil disimpan!', 'success');
  } catch (error) {
    console.error('Error saving warehouse:', error);
    Swal.fire('Error', 'Gagal menyimpan gudang', 'error');
  }
}

async function deleteWarehouse(id) {
  if (!confirm('Apakah Anda yakin ingin menghapus gudang ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/warehouses/${id}`, {
      method: 'DELETE'
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Gudang berhasil dihapus!', 'success');
  } catch (error) {
    console.error('Error deleting warehouse:', error);
    Swal.fire('Error', 'Gagal menghapus gudang', 'error');
  }
}

// Stock Mutation Functions
async function openTransferModal() {
  try {
    // Load products and warehouses for the form
    const [productsResponse, warehousesResponse] = await Promise.all([
      fetch(`${API_BASE_URL}/products`),
      fetch(`${API_BASE_URL}/warehouses`)
    ]);

    const products = await productsResponse.json();
    const warehouses = await warehousesResponse.json();

    // Populate form selects
    const productSelect = document.getElementById('tf-product');
    const fromSelect = document.getElementById('tf-source');
    const toSelect = document.getElementById('tf-dest');

    if (productSelect) {
      productSelect.innerHTML = '<option value="">Pilih Produk</option>';
      products.forEach(p => {
        productSelect.innerHTML += `<option value="${p.id}">${p.name}</option>`;
      });
    }

    if (fromSelect && toSelect) {
      fromSelect.innerHTML = '<option value="">Pilih Gudang Asal</option>';
      toSelect.innerHTML = '<option value="">Pilih Gudang Tujuan</option>';
      warehouses.forEach(w => {
        fromSelect.innerHTML += `<option value="${w.id}">${w.name}</option>`;
        toSelect.innerHTML += `<option value="${w.id}">${w.name}</option>`;
      });
    }

    // Show modal
    const modal = document.getElementById('transfer-modal');
    if (modal) {
      modal.classList.remove('hidden');
    }
  } catch (error) {
    console.error('Error opening transfer modal:', error);
    Swal.fire('Error', 'Gagal membuka modal transfer', 'error');
  }
}

function closeTransferModal() {
  const modal = document.getElementById('transfer-modal');
  if (modal) {
    modal.classList.add('hidden');
  }
}

async function saveTransfer(e) {
  e.preventDefault();

  try {
    const formData = new FormData(e.target);
    const data = {
      product_id: parseInt(formData.get('product_id')),
      from_warehouse_id: parseInt(formData.get('from_warehouse_id')),
      to_warehouse_id: parseInt(formData.get('to_warehouse_id')),
      quantity: parseFloat(formData.get('quantity')),
      reference_type: 'transfer',
      reference_number: `TF-${Date.now()}`,
      notes: formData.get('notes') || ''
    };

    const response = await fetch(`${API_BASE_URL}/stock-mutations`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Close modal
    closeTransferModal();

    // Reset form
    e.target.reset();

    // Refresh data
    await loadDashboardData();

    Swal.fire('Berhasil', 'Permintaan transfer berhasil dibuat!', 'success');
  } catch (error) {
    console.error('Error saving transfer:', error);
    Swal.fire('Error', 'Gagal membuat permintaan transfer', 'error');
  }
}

async function approveTransfer(id) {
  if (!confirm('Apakah Anda yakin ingin menyetujui transfer ini?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/stock-mutations/${id}/approve`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    await loadDashboardData();
    Swal.fire('Berhasil', 'Transfer berhasil disetujui!', 'success');
  } catch (error) {
    console.error('Error approving transfer:', error);
    Swal.fire('Error', 'Gagal menyetujui transfer', 'error');
  }
}

// Utility Functions (keeping existing simulations where API endpoints don't exist)
function adjustStockSim(sku, warehouse) {
  Swal.fire({
    title: 'Stock Adjustment',
    text: `Masukkan jumlah stok fisik aktual untuk ${sku} di ${warehouse}`,
    input: 'number',
    inputAttributes: {
      min: 0,
      step: 1
    },
    showCancelButton: true,
    confirmButtonText: 'Sesuaikan',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.value) {
      // In a real app, this would call an API to adjust stock
      Swal.fire('Berhasil', 'Stok berhasil disesuaikan!', 'success');
      // Refresh data to reflect changes
      loadDashboardData();
    }
  });
}

function orderStockSim(name) {
  Swal.fire({
    title: 'Buat PO Otomatis?',
    text: `Ingin membuat Pre-Order otomatis untuk ${name}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Buat PO',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire('Berhasil', 'Pre-Order berhasil dibuat dan masuk di modul Pembelian!', 'success');
    }
  });
}

// Payment Functions (keeping existing simulations)
function openPaymentModal() {
  if (posCart.length === 0) {
    Swal.fire('Keranjang Kosong', 'Silakan pilih produk terlebih dahulu.', 'warning');
    return;
  }
  document.getElementById('payment-modal').classList.remove('hidden');
  selectPaymentMethod('Tunai');
  calculateChange();
}

function closePaymentModal() {
  document.getElementById('payment-modal').classList.add('hidden');
}

function selectPaymentMethod(method) {
  activePaymentMethod = method;
  document.querySelectorAll('.pay-method-btn').forEach(btn => {
    btn.className = "pay-method-btn py-3 border border-cream-dark hover:bg-cream rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";
  });
  document.getElementById('pay-btn-' + method).className = "pay-method-btn py-3 border border-primary bg-primary-light text-zinc-900 rounded-xl text-xs font-bold flex flex-col items-center gap-1.5 transition-all";

  if (method === 'Tunai') {
    document.getElementById('cash-input-group').classList.remove('hidden');
  } else {
    document.getElementById('cash-input-group').classList.add('hidden');
  }
}

function presetCashAmount(amt) {
  document.getElementById('cash-received-input').value = amt;
  calculateChange();
}

function calculateChange() {
  let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
  let total = parseInt(totalDisplay) || 0;
  let received = parseInt(document.getElementById('cash-received-input').value) || 0;
  let change = received - total;

  if (change < 0) {
    document.getElementById('cash-change-display').innerText = 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
  } else {
    document.getElementById('cash-change-display').innerText = 'Rp ' + change.toLocaleString('id-ID');
  }
}

function processPOSCheckout() {
  let totalDisplay = document.getElementById('payment-modal-total').innerText.replace(/[^\d]/g, '');
  let total = parseInt(totalDisplay) || 0;
  let received = parseInt(document.getElementById('cash-received-input').value) || 0;

  if (activePaymentMethod === 'Tunai' && received < total) {
    Swal.fire('Uang Kurang', 'Pembayaran tunai yang diterima kurang dari total belanja.', 'error');
    return;
  }

  // Deduct stock simulation (in real app, this would be done via API)
  posCart.forEach(item => {
    // This would normally be done via a stock mutation API call
    // For now, we'll simulate it
  });

  closePaymentModal();
  renderReceipt(total, received);
  clearPOSCart();
  // Refresh data to reflect stock changes
  loadDashboardData();

  // Add cash transaction (simulated)
  Swal.fire('Berhasil', 'Transaksi berhasil diproses!', 'success');
}

function renderReceipt(total, received) {
  document.getElementById('rec-no').innerText = 'TRX-' + Date.now();
  document.getElementById('rec-date').innerText = new Date().toLocaleString();

  // Dynamic receipt configurations
  let rTitle = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
  let rEmail = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
  let rAddress = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
  let rFooter = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';

  document.getElementById('rec-header-title').innerText = rTitle;
  document.getElementById('rec-header-email').innerText = rEmail;
  document.getElementById('rec-header-address').innerText = rAddress;
  document.getElementById('rec-footer-text').innerText = rFooter;

  let custIdx = document.getElementById('pos-customer-select') ? parseInt(document.getElementById('pos-customer-select').value) : 0;
  document.getElementById('rec-customer').innerText = state.customers[custIdx]?.name + ' (' + state.customers[custIdx]?.type + ')';

  let itemsHTML = '';
  posCart.forEach(item => {
    let price = item.product.retail_price || 0;
    if (state.customers[custIdx]?.type === 'Agen') price = item.product.agency_price || item.product.retail_price * 0.9;
    if (state.customers[custIdx]?.type === 'Distributor') price = item.product.wholesale_price || item.product.retail_price * 0.8;
    itemsHTML += `
      <div class="flex justify-between">
        <span>${item.product.name} x${item.qty}</span>
        <span>Rp ${(price * item.qty).toLocaleString('id-ID')}</span>
      </div>
    `;
  });

  document.getElementById('rec-items').innerHTML = itemsHTML;
  document.getElementById('rec-subtotal').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
  document.getElementById('rec-total').innerText = 'Rp ' + Math.round(total).toLocaleString('id-ID');
  document.getElementById('rec-paid').innerText = 'Rp ' + (activePaymentMethod === 'Tunai' ? received : total).toLocaleString('id-ID');

  let change = received - total;
  document.getElementById('rec-change').innerText = 'Rp ' + (change > 0 && activePaymentMethod === 'Tunai' ? change : 0).toLocaleString('id-ID');

  document.getElementById('receipt-modal').classList.remove('hidden');
}

function closeReceiptModal() {
  document.getElementById('receipt-modal').classList.add('hidden');
}

function updateLiveReceiptPreview() {
  let title = document.getElementById('set-receipt-title').value || 'DEPOT AIR ELANGWATER';
  let email = document.getElementById('set-receipt-email').value || 'info@elangwater.com';
  let address = document.getElementById('set-receipt-address').value || 'Jl. H. Abdurrahman No. 12, Denpasar';
  let footer = document.getElementById('set-receipt-footer').value || 'Air Bersih Sehat Keluarga Anda';
  let showLogo = document.getElementById('set-receipt-show-logo').checked;
  let paperSize = document.querySelector('input[name="paper-size"]:checked')?.value || '58mm';

  document.getElementById('preview-rec-title').innerText = title;
  document.getElementById('preview-rec-email').innerText = email;
  document.getElementById('preview-rec-address').innerText = address;
  document.getElementById('preview-rec-footer').innerText = footer;
  document.getElementById('preview-paper-size-badge').innerText = paperSize;
  document.getElementById('preview-logo-icon').style.display = showLogo ? 'block' : 'none';
}

function saveReceiptSettingsSim() {
  updateLiveReceiptPreview();
  Swal.fire('Berhasil', 'Pengaturan struk dan notifikasi berhasil disimpan.', 'success');
}

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  // Initialize Lucide icons
  lucide.createIcons();

  // Load initial data
  loadDashboardData();

  // Set up event listeners for form submissions if needed
  setupFormListeners();

  // Set up workspace tab switching (copied from original)
  window.switchTab = function(tabId) {
    document.querySelectorAll('#workspace-content [id^="section-"]').forEach(div => div.classList.add('hidden'));

    let targetDiv = document.getElementById('section-' + tabId);
    if (targetDiv) {
      targetDiv.classList.remove('hidden');
    }

    // Remove active classes from navigation items
    document.querySelectorAll('#main-navigation button').forEach(btn => {
      btn.className = btn.className.replace('bg-primary text-zinc-900 shadow-sm border border-primary/20', 'text-zinc-700 hover:text-zinc-900');
    });

    // Set active class on main menu buttons if applicable
    let mainNavBtn = document.getElementById('nav-' + tabId.split('-')[0]);
    if (mainNavBtn) {
      mainNavBtn.className = "w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream bg-primary text-zinc-900 shadow-sm border border-primary/20";
    }

    activeTab = tabId;
    lucide.createIcons();

    if (mobileSidebarOpen) {
      closeMobileSidebar();
    }
  };
});

// Initialize sidebar and mobile menu functions (copied from original)
function toggleMobileSidebar() {
  let sidebar = document.getElementById('main-sidebar');
  let overlay = document.getElementById('mobile-sidebar-overlay');
  if (sidebar.classList.contains('-translate-x-full')) {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    mobileSidebarOpen = true;
  } else {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    mobileSidebarOpen = false;
  }
}

function closeMobileSidebar() {
  let sidebar = document.getElementById('main-sidebar');
  let overlay = document.getElementById('mobile-sidebar-overlay');
  sidebar.classList.add('-translate-x-full');
  overlay.classList.add('hidden');
  mobileSidebarOpen = false;
}

window.addEventListener('resize', () => {
  if (window.innerWidth >= 768) {
    closeMobileSidebar();
  }
});



function filterPOSCatalog() {
  let q = document.getElementById('pos-search-input').value.toLowerCase();
  let cards = document.querySelectorAll('#pos-catalog-grid > div');
  cards.forEach(card => {
    let name = card.querySelector('h4').innerText.toLowerCase();
    let category = card.querySelector('span').innerText.toLowerCase();
    if (name.includes(q) || category.includes(q)) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}

function filterPOSCategory(e, cat) {
  document.querySelectorAll('.pos-cat-btn').forEach(btn => {
    btn.className = "pos-cat-btn px-4 py-1.5 bg-cream-dark hover:bg-zinc-200 rounded-full text-xs font-semibold transition-all";
  });
  if (e && e.currentTarget) {
    e.currentTarget.className = "pos-cat-btn px-4 py-1.5 bg-zinc-950 text-white rounded-full text-xs font-bold transition-all";
  }

  let cards = document.querySelectorAll('#pos-catalog-grid > div');
  cards.forEach(card => {
    let category = card.querySelector('span').innerText;
    if (cat === '' || category === cat.toUpperCase()) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}

function populateSelects() {
  // Customer select in POS
  let select = document.getElementById('pos-customer-select');
  if (select) {
    select.innerHTML = '';
    state.customers.forEach((c, idx) => {
      select.innerHTML += `<option value="${idx}">${c.name} (${c.type})</option>`;
    });
  }

  // SKU filter in Kartu Stok
  let skuSelect = document.getElementById('kartu-stok-sku-filter');
  if (skuSelect) {
    skuSelect.innerHTML = '<option value="">Pilih SKU Produk</option>';
    state.products.forEach(p => {
      skuSelect.innerHTML += `<option value="${p.sku}">${p.name} (${p.sku})</option>`;
    });
  }

  // Add Product modal & Transfer modal Selects
  let tfProd = document.getElementById('tf-product');
  if (tfProd) {
    tfProd.innerHTML = '';
    state.products.forEach(p => {
      tfProd.innerHTML += `<option value="${p.id}">${p.name}</option>`;
    });
  }

  // Category selects
  let categorySelects = document.querySelectorAll('select[data-category-select]');
  categorySelects.forEach(select => {
    select.innerHTML = '<option value="">Pilih Kategori</option>';
    state.categories.forEach(c => {
      select.innerHTML += `<option value="${c.id}">${c.name}</option>`;
    });
  });

  // Brand selects
  let brandSelects = document.querySelectorAll('select[data-brand-select]');
  brandSelects.forEach(select => {
    select.innerHTML = '<option value="">Pilih Brand</option>';
    state.brands.forEach(b => {
      select.innerHTML += `<option value="${b.id}">${b.name}</option>`;
    });
  });

  // Unit selects
  let unitSelects = document.querySelectorAll('select[data-unit-select]');
  unitSelects.forEach(select => {
    select.innerHTML = '<option value="">Pilih Satuan</option>';
    state.units.forEach(u => {
      select.innerHTML += `<option value="${u.id}">${u.name}</option>`;
    });
  });

  // Warehouse selects
  let warehouseSelects = document.querySelectorAll('select[data-warehouse-select]');
  warehouseSelects.forEach(select => {
    select.innerHTML = '<option value="">Pilih Gudang</option>';
    state.warehouses.forEach(w => {
      select.innerHTML += `<option value="${w.id}">${w.name}</option>`;
    });
  });
}

// Initialize selects after data loads
document.addEventListener('DOMContentLoaded', async () => {
  await loadDashboardData();
  populateSelects();
});

// Export functions for use in HTML windows
window.saveProduct = saveProduct;
window.deleteProduct = deleteProduct;
window.saveCategory = saveCategory;
window.deleteCategory = deleteCategory;
window.saveBrand = saveBrand;
window.deleteBrand = deleteBrand;
window.saveUnit = saveUnit;
window.deleteUnit = deleteUnit;
window.saveWarehouse = saveWarehouse;
window.deleteWarehouse = deleteWarehouse;
window.openTransferModal = openTransferModal;
window.closeTransferModal = closeTransferModal;
window.saveTransfer = saveTransfer;
window.approveTransfer = approveTransfer;
window.adjustStockSim = adjustStockSim;
window.orderStockSim = orderStockSim;
window.openPaymentModal = openPaymentModal;
window.closePaymentModal = closePaymentModal;
window.selectPaymentMethod = selectPaymentMethod;
window.presetCashAmount = presetCashAmount;
window.calculateChange = calculateChange;
window.processPOSCheckout = processPOSCheckout;
window.renderReceipt = renderReceipt;
window.closeReceiptModal = closeReceiptModal;
window.updateLiveReceiptPreview = updateLiveReceiptPreview;
window.saveReceiptSettingsSim = saveReceiptSettingsSim;
window.addToPOSCart = addToPOSCart;
window.changeCartQty = changeCartQty;
window.clearPOSCart = clearPOSCart;
window.recalculatePOSCartTotal = recalculatePOSCartTotal;
window.renderPOSCart = renderPOSCart;
window.populateSelects = populateSelects;
window.filterPOSCatalog = filterPOSCatalog;
window.filterPOSCategory = filterPOSCategory;
window.toggleMobileSidebar = toggleMobileSidebar;
window.closeMobileSidebar = closeMobileSidebar;
window.switchTab = window.switchTab || function(tabId) {
  document.querySelectorAll('#workspace-content [id^="section-"]').forEach(div => div.classList.add('hidden'));

  let targetDiv = document.getElementById('section-' + tabId);
  if (targetDiv) {
    targetDiv.classList.remove('hidden');
  }

  // Remove active classes from navigation items
  document.querySelectorAll('#main-navigation button').forEach(btn => {
    btn.className = btn.className.replace('bg-primary text-zinc-900 shadow-sm border border-primary/20', 'text-zinc-700 hover:text-zinc-900');
  });

  // Set active class on main menu buttons if applicable
  let mainNavBtn = document.getElementById('nav-' + tabId.split('-')[0]);
  if (mainNavBtn) {
    mainNavBtn.className = "w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all hover:bg-cream bg-primary text-zinc-900 shadow-sm border border-primary/20";
  }

  activeTab = tabId;
  lucide.createIcons();

  if (mobileSidebarOpen) {
    closeMobileSidebar();
  }
};
