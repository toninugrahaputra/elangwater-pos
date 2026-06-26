RBAC
roles
Field	Type
id	bigint
name	varchar
guard_name	varchar
users
Field	Type
id	bigint
name	varchar
username	varchar
email	varchar
password	varchar
phone	varchar
status	boolean
created_at	timestamp
Master Data
categories
Field	Type
id	bigint
name	varchar
parent_id	nullable
brands
Field	Type
id	bigint
name	varchar
units
Field	Type
id	bigint
name	varchar
products
Field	Type
id	bigint
sku	varchar
barcode	varchar
category_id	fk
brand_id	fk
unit_id	fk
name	varchar
volume	varchar
cost_price	decimal
retail_price	decimal
wholesale_price	decimal
minimum_stock	integer
photo	varchar
status	boolean
Gudang
warehouses
Field	Type
id	bigint
code	varchar
name	varchar
address	text
is_active	boolean
warehouse_stocks
Field	Type
id	bigint
warehouse_id	fk
product_id	fk
qty	decimal

Unique:

warehouse_id + product_id
Pelanggan
customers
Field	Type
id	bigint
code	varchar
name	varchar
type	enum
phone	varchar
address	text
credit_limit	decimal
notes	text
Supplier
suppliers
Field	Type
id	bigint
code	varchar
name	varchar
phone	varchar
email	varchar
address	text
notes	text
Pembelian
purchases
Field	Type
id	bigint
invoice_number	varchar
supplier_id	fk
warehouse_id	fk
purchase_date	date
subtotal	decimal
discount	decimal
tax	decimal
total	decimal
status	enum
created_by	fk
purchase_items
Field	Type
id	bigint
purchase_id	fk
product_id	fk
qty	decimal
cost_price	decimal
total	decimal
purchase_returns
Field	Type
id	bigint
purchase_id	fk
return_date	datetime
notes	text
created_by	fk
purchase_return_items
Field	Type
id	bigint
purchase_return_id	fk
product_id	fk
qty	decimal
amount	decimal
Penjualan
sales
Field	Type
id	bigint
invoice_number	varchar
customer_id	nullable
warehouse_id	fk
sale_date	datetime
subtotal	decimal
discount	decimal
tax	decimal
total	decimal
payment_status	enum
created_by	fk
sale_items
Field	Type
id	bigint
sale_id	fk
product_id	fk
qty	decimal
price	decimal
discount	decimal
total	decimal
sale_payments
Field	Type
id	bigint
sale_id	fk
payment_method	enum
amount	decimal
reference_number	varchar
paid_at	datetime

Metode:

CASH
TRANSFER
QRIS
EWALLET

Keuntungannya:

Mendukung split payment
Mendukung multi pembayaran
Lebih fleksibel
Retur Penjualan
sale_returns
Field	Type
id	bigint
sale_id	fk
return_date	datetime
notes	text
created_by	fk
sale_return_items
Field	Type
id	bigint
sale_return_id	fk
product_id	fk
qty	decimal
amount	decimal
Transfer Gudang
stock_transfers
Field	Type
id	bigint
transfer_number	varchar
from_warehouse_id	fk
to_warehouse_id	fk
transfer_date	datetime
status	enum
notes	text
stock_transfer_items
Field	Type
id	bigint
stock_transfer_id	fk
product_id	fk
qty	decimal
Stock Opname
stock_opnames
Field	Type
id	bigint
warehouse_id	fk
opname_date	date
notes	text
created_by	fk
stock_opname_items
Field	Type
id	bigint
stock_opname_id	fk
product_id	fk
system_qty	decimal
physical_qty	decimal
difference_qty	decimal
Kartu Stok
stock_movements
Field	Type
id	bigint
warehouse_id	fk
product_id	fk
transaction_type	enum
reference_type	varchar
reference_id	bigint
qty_in	decimal
qty_out	decimal
balance_after	decimal
transaction_date	datetime
Kas
cash_categories
Field	Type
id	bigint
name	varchar
cash_transactions
Field	Type
id	bigint
category_id	fk
transaction_date	date
type	enum
amount	decimal
description	text
created_by	fk
Sistem
settings

Digunakan untuk seluruh konfigurasi aplikasi.

Field	Type
id	bigint
key	varchar
value	text
type	varchar
updated_by	bigint

Contoh:

company_name
company_address
receipt_title
receipt_email
receipt_note
receipt_logo
receipt_paper_size
auto_print_receipt
send_receipt_email
notifications
Field	Type
id	bigint
user_id	fk
title	varchar
message	text
type	varchar
is_read	boolean
created_at	timestamp
audit_logs
Field	Type
id	bigint
user_id	fk
module	varchar
action	varchar
old_value	json
new_value	json
ip_address	varchar
created_at	timestamp
Future Ready (V2)
stores

Jika nanti ingin multi toko.

Field	Type
id	bigint
code	varchar
name	varchar
address	text
phone	varchar
is_active	boolean

lalu tambahkan : 
users.store_id
warehouses.store_id
sales.store_id
purchases.store_id
sehingga sistem langsung berubah menjadi multi cabang tanpa refactor besar.