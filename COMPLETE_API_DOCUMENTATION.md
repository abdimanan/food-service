# Complete API Documentation

Base URL: `/api/v1`

All endpoints return JSON responses. Default pagination: 15 items per page.

---

## Table of Contents

1. [Health Check](#1-health-check)
2. [Categories](#2-categories)
3. [Products](#3-products)
4. [Variants](#4-variants)
5. [Variant Options](#5-variant-options)
6. [Product Variant Prices](#6-product-variant-prices)
7. [Addons](#7-addons)
8. [Product Addons](#8-product-addons)

---

## 1. Health Check

### GET `/api/v1/health`

Check API health status.

**Response (200 OK):**
```json
{
  "status": "ok",
  "service": "api",
  "version": "v1"
}
```

---

## 2. Categories

### GET `/api/v1/categories`

List all categories with pagination.

**Query Parameters:**
- `is_active` (boolean) - Filter by active status
- `search` (string) - Search in name or slug
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/categories?is_active=true&search=pizza
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Main Courses",
      "slug": "main-courses",
      "is_active": true,
      "created_at": "2025-12-30T09:27:24.000000Z",
      "updated_at": "2025-12-30T09:27:24.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost/api/v1/categories?page=1",
    "last": "http://localhost/api/v1/categories?page=3",
    "prev": null,
    "next": "http://localhost/api/v1/categories?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "path": "http://localhost/api/v1/categories",
    "per_page": 15,
    "to": 15,
    "total": 35
  }
}
```

### GET `/api/v1/categories/{id}`

Show a specific category.

**Response (200 OK):**
```json
{
  "data": {
    "id": 1,
    "name": "Main Courses",
    "slug": "main-courses",
    "is_active": true,
    "created_at": "2025-12-30T09:27:24.000000Z",
    "updated_at": "2025-12-30T09:27:24.000000Z"
  }
}
```

### POST `/api/v1/categories`

Create a new category.

**Request Body:**
```json
{
  "name": "Desserts",
  "slug": "desserts",
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 2,
    "name": "Desserts",
    "slug": "desserts",
    "is_active": true,
    "created_at": "2025-12-31T10:00:00.000000Z",
    "updated_at": "2025-12-31T10:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/categories/{id}`

Update a category.

**Request Body:**
```json
{
  "name": "Sweet Desserts",
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/categories/{id}`

Delete a category.

**Response (200 OK):**
```json
{
  "message": "Category deleted successfully"
}
```

---

## 3. Products

### GET `/api/v1/products`

List all products with pagination.

**Query Parameters:**
- `category_id` (integer) - Filter by category
- `vendor_id` (integer) - Filter by vendor ID
- `is_live` (boolean) - Filter by live status
- `search` (string) - Search in name or slug
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/products?category_id=1&is_live=true
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "vendor_id": 123,
      "category": {
        "id": 1,
        "name": "Main Courses",
        "slug": "main-courses",
        "is_active": true,
        "created_at": "2025-12-30T09:27:24.000000Z",
        "updated_at": "2025-12-30T09:27:24.000000Z"
      },
      "category_id": 1,
      "name": "Margherita Pizza",
      "slug": "margherita-pizza",
      "description": "Classic pizza with tomato sauce, mozzarella, and basil",
      "price": "12.99",
      "is_live": true,
      "preparation_time": 20,
      "min_order_quantity": 1,
      "variants": [],
      "addons": [],
      "media": [],
      "tags": [],
      "created_at": "2025-12-30T10:45:00.000000Z",
      "updated_at": "2025-12-30T10:45:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 35 }
}
```

### GET `/api/v1/products/{id}`

Show a specific product.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/products`

Create a new product.

**Request Body:**
```json
{
  "vendor_id": 123,
  "category_id": 1,
  "name": "Margherita Pizza",
  "slug": "margherita-pizza",
  "description": "Classic pizza",
  "price": 12.99,
  "is_live": false,
  "preparation_time": 20,
  "min_order_quantity": 1
}
```

**Response (201 Created):** Same structure as GET response

---

## 4. Variants

### GET `/api/v1/variants`

List all variants with their options.

**Query Parameters:**
- `is_active` (boolean) - Filter by active status
- `search` (string) - Search in name
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/variants?is_active=true
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Size",
      "is_active": true,
      "options": [
        {
          "id": 1,
          "variant_id": 1,
          "variant": null,
          "name": "Small",
          "is_active": true,
          "created_at": "2025-12-31T10:00:00.000000Z",
          "updated_at": "2025-12-31T10:00:00.000000Z"
        },
        {
          "id": 2,
          "variant_id": 1,
          "variant": null,
          "name": "Large",
          "is_active": true,
          "created_at": "2025-12-31T10:00:00.000000Z",
          "updated_at": "2025-12-31T10:00:00.000000Z"
        }
      ],
      "created_at": "2025-12-31T10:00:00.000000Z",
      "updated_at": "2025-12-31T10:00:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 10 }
}
```

### GET `/api/v1/variants/{id}`

Show a specific variant with options.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/variants`

Create a new variant.

**Request Body:**
```json
{
  "name": "Size",
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "name": "Size",
    "is_active": true,
    "options": [],
    "created_at": "2025-12-31T10:00:00.000000Z",
    "updated_at": "2025-12-31T10:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/variants/{id}`

Update a variant.

**Request Body:**
```json
{
  "name": "Portion Size",
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/variants/{id}`

Delete a variant.

**Response (200 OK):**
```json
{
  "message": "Variant deleted successfully"
}
```

---

## 5. Variant Options

### GET `/api/v1/variant-options`

List all variant options.

**Query Parameters:**
- `variant_id` (integer) - Filter by variant ID
- `is_active` (boolean) - Filter by active status
- `search` (string) - Search in name
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/variant-options?variant_id=1&is_active=true
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "variant_id": 1,
      "variant": {
        "id": 1,
        "name": "Size",
        "is_active": true,
        "options": [],
        "created_at": "2025-12-31T10:00:00.000000Z",
        "updated_at": "2025-12-31T10:00:00.000000Z"
      },
      "name": "Small",
      "is_active": true,
      "created_at": "2025-12-31T10:00:00.000000Z",
      "updated_at": "2025-12-31T10:00:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 25 }
}
```

### GET `/api/v1/variant-options/{id}`

Show a specific variant option.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/variant-options`

Create a new variant option.

**Request Body:**
```json
{
  "variant_id": 1,
  "name": "Small",
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "variant_id": 1,
    "variant": null,
    "name": "Small",
    "is_active": true,
    "created_at": "2025-12-31T10:00:00.000000Z",
    "updated_at": "2025-12-31T10:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/variant-options/{id}`

Update a variant option.

**Request Body:**
```json
{
  "name": "Small (8\")",
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/variant-options/{id}`

Delete a variant option.

**Response (200 OK):**
```json
{
  "message": "Variant option deleted successfully"
}
```

---

## 6. Product Variant Prices

### GET `/api/v1/product-variant-prices`

List all product variant prices.

**Query Parameters:**
- `product_id` (integer) - Filter by product ID
- `variant_option_id` (integer) - Filter by variant option ID
- `is_active` (boolean) - Filter by active status
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/product-variant-prices?product_id=1
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "product_id": 1,
      "product": {
        "id": 1,
        "vendor_id": 123,
        "category": null,
        "category_id": 1,
        "name": "Margherita Pizza",
        "slug": "margherita-pizza",
        "description": "Classic pizza",
        "price": "12.99",
        "is_live": true,
        "preparation_time": 20,
        "min_order_quantity": 1,
        "variants": [],
        "addons": [],
        "media": [],
        "tags": [],
        "created_at": "2025-12-30T10:45:00.000000Z",
        "updated_at": "2025-12-30T10:45:00.000000Z"
      },
      "variant_option_id": 1,
      "variant_option": {
        "id": 1,
        "variant_id": 1,
        "variant": null,
        "name": "Small",
        "is_active": true,
        "created_at": "2025-12-31T10:00:00.000000Z",
        "updated_at": "2025-12-31T10:00:00.000000Z"
      },
      "price": "9.99",
      "is_active": true,
      "created_at": "2025-12-31T11:00:00.000000Z",
      "updated_at": "2025-12-31T11:00:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 50 }
}
```

### GET `/api/v1/product-variant-prices/{id}`

Show a specific product variant price.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/product-variant-prices`

Create a new product variant price.

**Request Body:**
```json
{
  "product_id": 1,
  "variant_option_id": 1,
  "price": 9.99,
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "product_id": 1,
    "product": null,
    "variant_option_id": 1,
    "variant_option": null,
    "price": "9.99",
    "is_active": true,
    "created_at": "2025-12-31T11:00:00.000000Z",
    "updated_at": "2025-12-31T11:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/product-variant-prices/{id}`

Update a product variant price.

**Request Body:**
```json
{
  "price": 10.99,
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/product-variant-prices/{id}`

Delete a product variant price.

**Response (200 OK):**
```json
{
  "message": "Product variant price deleted successfully"
}
```

---

## 7. Addons

### GET `/api/v1/addons`

List all addons.

**Query Parameters:**
- `is_active` (boolean) - Filter by active status
- `search` (string) - Search in name
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/addons?is_active=true&search=cheese
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Extra Cheese",
      "base_price": "2.00",
      "is_active": true,
      "created_at": "2025-12-31T12:00:00.000000Z",
      "updated_at": "2025-12-31T12:00:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 20 }
}
```

### GET `/api/v1/addons/{id}`

Show a specific addon.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/addons`

Create a new addon.

**Request Body:**
```json
{
  "name": "Extra Cheese",
  "base_price": 2.00,
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "name": "Extra Cheese",
    "base_price": "2.00",
    "is_active": true,
    "created_at": "2025-12-31T12:00:00.000000Z",
    "updated_at": "2025-12-31T12:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/addons/{id}`

Update an addon.

**Request Body:**
```json
{
  "base_price": 2.50,
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/addons/{id}`

Delete an addon.

**Response (200 OK):**
```json
{
  "message": "Addon deleted successfully"
}
```

---

## 8. Product Addons

### GET `/api/v1/product-addons`

List all product addons.

**Query Parameters:**
- `product_id` (integer) - Filter by product ID
- `addon_id` (integer) - Filter by addon ID
- `is_active` (boolean) - Filter by active status
- `page` (integer) - Page number

**Example Request:**
```bash
GET /api/v1/product-addons?product_id=1
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "product_id": 1,
      "product": {
        "id": 1,
        "vendor_id": 123,
        "category": null,
        "category_id": 1,
        "name": "Margherita Pizza",
        "slug": "margherita-pizza",
        "description": "Classic pizza",
        "price": "12.99",
        "is_live": true,
        "preparation_time": 20,
        "min_order_quantity": 1,
        "variants": [],
        "addons": [],
        "media": [],
        "tags": [],
        "created_at": "2025-12-30T10:45:00.000000Z",
        "updated_at": "2025-12-30T10:45:00.000000Z"
      },
      "addon_id": 1,
      "addon": {
        "id": 1,
        "name": "Extra Cheese",
        "base_price": "2.00",
        "is_active": true,
        "created_at": "2025-12-31T12:00:00.000000Z",
        "updated_at": "2025-12-31T12:00:00.000000Z"
      },
      "price_override": null,
      "effective_price": "2.00",
      "is_active": true,
      "created_at": "2025-12-31T13:00:00.000000Z",
      "updated_at": "2025-12-31T13:00:00.000000Z"
    },
    {
      "id": 2,
      "product_id": 1,
      "product": { ... },
      "addon_id": 2,
      "addon": {
        "id": 2,
        "name": "Pepperoni",
        "base_price": "3.50",
        "is_active": true,
        "created_at": "2025-12-31T12:00:00.000000Z",
        "updated_at": "2025-12-31T12:00:00.000000Z"
      },
      "price_override": "4.00",
      "effective_price": "4.00",
      "is_active": true,
      "created_at": "2025-12-31T13:00:00.000000Z",
      "updated_at": "2025-12-31T13:00:00.000000Z"
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 30 }
}
```

### GET `/api/v1/product-addons/{id}`

Show a specific product addon.

**Response (200 OK):** Same structure as list item

### POST `/api/v1/product-addons`

Create a new product addon.

**Request Body:**
```json
{
  "product_id": 1,
  "addon_id": 1,
  "price_override": null,
  "is_active": true
}
```

**Or with price override:**
```json
{
  "product_id": 1,
  "addon_id": 1,
  "price_override": 2.50,
  "is_active": true
}
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "product_id": 1,
    "product": null,
    "addon_id": 1,
    "addon": null,
    "price_override": null,
    "effective_price": "2.00",
    "is_active": true,
    "created_at": "2025-12-31T13:00:00.000000Z",
    "updated_at": "2025-12-31T13:00:00.000000Z"
  }
}
```

### PUT/PATCH `/api/v1/product-addons/{id}`

Update a product addon.

**Request Body:**
```json
{
  "price_override": 2.75,
  "is_active": false
}
```

**Response (200 OK):** Same structure as GET response

### DELETE `/api/v1/product-addons/{id}`

Delete a product addon.

**Response (200 OK):**
```json
{
  "message": "Product addon deleted successfully"
}
```

---

## Common Response Patterns

### Pagination Structure

All list endpoints return paginated responses with this structure:

```json
{
  "data": [...],
  "links": {
    "first": "http://localhost/api/v1/resource?page=1",
    "last": "http://localhost/api/v1/resource?page=3",
    "prev": null,
    "next": "http://localhost/api/v1/resource?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "path": "http://localhost/api/v1/resource",
    "per_page": 15,
    "to": 15,
    "total": 35
  }
}
```

### Error Response (422 Validation Error)

```json
{
  "message": "The variant name is required. (and 1 more error)",
  "errors": {
    "name": [
      "The variant name is required."
    ],
    "variant_id": [
      "The selected variant does not exist."
    ]
  }
}
```

### Error Response (404 Not Found)

```json
{
  "message": "No query results for model [App\\Models\\Variant] 999"
}
```

### Success Delete Response (200 OK)

```json
{
  "message": "Resource deleted successfully"
}
```

---

## Field Type Reference

| Field Type | Description | Example |
|------------|-------------|---------|
| `id` | Integer primary key | `1` |
| `name` | String (max 255 chars) | `"Margherita Pizza"` |
| `slug` | String (unique, max 255 chars) | `"margherita-pizza"` |
| `price` | Decimal (10,2) returned as string | `"12.99"` |
| `is_active` | Boolean | `true` or `false` |
| `created_at` | ISO 8601 timestamp | `"2025-12-31T10:00:00.000000Z"` |
| `updated_at` | ISO 8601 timestamp | `"2025-12-31T10:00:00.000000Z"` |

---

## Notes

- All timestamps are in ISO 8601 format (UTC)
- All prices are returned as strings to avoid floating-point precision issues
- Pagination defaults to 15 items per page
- Boolean query parameters accept: `true`, `false`, `1`, `0`, `"true"`, `"false"`
- Nested relationships are only included when explicitly loaded (using `with()` or `load()`)
- The `effective_price` field in Product Addons returns the `price_override` if set, otherwise the addon's `base_price`


