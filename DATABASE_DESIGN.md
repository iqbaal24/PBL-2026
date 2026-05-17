# Database And Admin Dashboard Design

## Overview

This system is designed for a small digital printing business where customers browse the public catalog, contact the shop through WhatsApp, and admins manually input the final order data in the Filament admin dashboard.

The design priorities are:

- Keep the admin order form short and fast to fill.
- Support custom printing specifications without many rigid fields.
- Allow one order to contain multiple products.
- Store uploaded design, proof, and receipt files safely outside the main order table.
- Keep catalog data structured enough for products, variants, and finishings.
- Support order tracking through a public order code.

## Database Tables

### users

Stores admin and superadmin accounts.

```text
id
name
email
password
role                 -- admin, superadmin
is_active
created_at
updated_at
```

### categories

Stores product catalog categories.

```text
id
name
slug
is_active
created_at
updated_at
```

### products

Stores products shown in the public catalog.

```text
id
category_id
name
slug
description nullable
image nullable
base_price nullable
is_active
created_at
updated_at
```

### product_variants

Stores product-specific variants such as paper size, package quantity, material option, or other common choices.

```text
id
product_id
name                 -- example: A4, A3, 100 pcs, 500 pcs
is_active
created_at
updated_at
```

### product_finishings

Stores finishing options that belong directly to a product. There is no separate global `finishings` table to keep management simpler.

```text
id
product_id
name                 -- example: Laminating, Spiral, Hardcover, Eyelet
description nullable
is_active
created_at
updated_at
```

### orders

Stores the main order data. Customer data is stored directly here because customers order through WhatsApp and do not need accounts.

```text
id
order_code           -- example: ORD-20260517-0001
customer_name
customer_phone
customer_address nullable
deadline nullable
notes nullable
total_price nullable
paid_amount default 0
payment_status       -- unpaid, partial, paid
status               -- pending, confirmed, production, ready, completed, cancelled
admin_id
created_at
updated_at
```

### order_items

Stores products inside an order. One order can have many items.

```text
id
order_id
product_id nullable
product_variant_id nullable
product_finishing_id nullable
product_name
variant_name nullable
finishing_name nullable
quantity default 1
unit_price nullable
subtotal nullable
specification nullable
created_at
updated_at
```

Keep `product_name`, `variant_name`, and `finishing_name` as snapshots. This protects old order records if the catalog data is renamed later.

Example `specification`:

```text
Size: 2x1 meter, Material: Flexi China, Finishing: Eyelet, Note: urgent
```

### order_files

Stores files related to an order or a specific order item.

```text
id
order_id
order_item_id nullable
file_path
file_name
file_type            -- design, proof, receipt, other
uploaded_by
created_at
```

### order_status_histories

Stores status changes for tracking and audit history.

```text
id
order_id
status
note nullable
changed_by
created_at
```

### reviews

Stores public customer reviews.

```text
id
customer_name
product_id nullable
order_id nullable
rating
comment
is_visible
created_at
```

### store_profile

Stores editable business profile information.

```text
id
name
about nullable
address nullable
whatsapp_number
email nullable
logo nullable
instagram_url nullable
updated_at
```

## Relationships

```text
users 1 -> many orders
users 1 -> many order_files
users 1 -> many order_status_histories

categories 1 -> many products

products 1 -> many product_variants
products 1 -> many product_finishings
products 1 -> many order_items
products 1 -> many reviews

product_variants 1 -> many order_items
product_finishings 1 -> many order_items

orders 1 -> many order_items
orders 1 -> many order_files
orders 1 -> many order_status_histories
orders 1 -> many reviews

order_items 1 -> many order_files
```

## Recommended Laravel Models

```text
User
Category
Product
ProductVariant
ProductFinishing
Order
OrderItem
OrderFile
OrderStatusHistory
Review
StoreProfile
```

## Filament Sidebar

The sidebar should stay short. Avoid separate menu items for adding orders, uploading files, or updating statuses because those actions belong inside the order resource.

```text
Dashboard
Orders
Catalog
Reviews
Store Profile
Admin Users
```

The `Catalog` navigation group contains:

```text
Products
Categories
```

## Filament Resources

### OrderResource

Main resource for daily admin work.

Admin can manage the full order flow in one resource:

- View all orders.
- Add manual WhatsApp orders.
- Edit customer and order information.
- Add multiple order items.
- Select product, variant, and finishing.
- Write custom printing specifications.
- Upload design, proof, receipt, or other files.
- Update payment status.
- Update order status.
- View status history.

Recommended pages:

```text
ListOrders
CreateOrder
EditOrder
ViewOrder optional
```

Recommended form sections:

```text
Customer Info
Order Items
Payment
Files
Status
Notes
```

Minimum required fields:

```text
Customer name
WhatsApp number
Product
Quantity
Specification
Total price
Paid amount
Status
Upload file optional
```

### ProductResource

Used to manage catalog products.

Admin can manage:

- Product details.
- Product image.
- Base price.
- Active or inactive status.
- Variants.
- Finishings.

Variants and finishings should be managed as repeaters or relation managers inside the product form.

### CategoryResource

Used to manage product categories.

Admin can manage:

- Category name.
- Slug.
- Category image.
- Active or inactive status.

### ReviewResource

Used to moderate customer reviews.

Admin can manage:

- Customer name.
- Related product.
- Related order.
- Rating.
- Comment.
- Visible or hidden status.

### StoreProfileResource

Used to manage business profile content.

Recommended as a single-record resource or Filament settings page.

Admin can manage:

- Store name.
- About text.
- Address.
- WhatsApp number.
- Email.
- Logo.
- Instagram URL.

### UserResource

Used by superadmin only.

Superadmin can manage:

- Admin accounts.
- User role.
- Active or inactive status.

## Admin Order Input Flow

The admin receives order details from WhatsApp, then inputs them into Filament.

Recommended flow:

```text
1. Open Orders.
2. Click Create Order.
3. Fill customer name and WhatsApp number.
4. Add one or more order items.
5. Select product, variant, and finishing if available.
6. Write custom details in specification.
7. Upload design files if available.
8. Fill total price and paid amount.
9. Set order status.
10. Save.
```

## Status Values

Recommended order statuses:

```text
pending
confirmed
production
ready
completed
cancelled
```

Recommended payment statuses:

```text
unpaid
partial
paid
```

Recommended file types:

```text
design
proof
receipt
other
```

## Public Website Pages

The public website can be supported by the same database design.

```text
Home
Catalog
Product Detail
Track Order
Reviews
About Us
Contact / WhatsApp
```

The `Track Order` page should use `order_code` and `customer_phone` to show the current order status.

## Notes

This design intentionally avoids a customer account table because customers order through WhatsApp. If the business later needs customer login, repeat orders, or customer order history, add a `customers` table and link it to `orders`.

This design also intentionally uses product-specific `product_finishings` instead of a global finishing table. This keeps Filament management simpler for a small shop. If the catalog becomes large and finishing duplication becomes a problem, add a global `finishings` table later.
