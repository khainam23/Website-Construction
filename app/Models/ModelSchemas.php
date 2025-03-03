<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     schema="Sale",
 *     required={"device_id", "user_id", "quantity", "total_price"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="device_id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="total_price", type="number", format="float"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Report",
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Rental",
 *     required={"user_id", "device_id", "rental_date", "return_date", "rental_fee"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="device_id", type="integer"),
 *     @OA\Property(property="rental_date", type="string", format="date"),
 *     @OA\Property(property="return_date", type="string", format="date"),
 *     @OA\Property(property="rental_fee", type="number", format="float"),
 *     @OA\Property(property="status", type="string", enum={"pending", "active", "completed", "cancelled"}),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Order",
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="status", type="string", enum={"pending", "processing", "completed", "cancelled"}),
 *     @OA\Property(property="total_amount", type="number", format="float"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Invoice",
 *     required={"user_id", "invoice_number", "total_amount"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="invoice_number", type="string"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="subtotal", type="number", format="float"),
 *     @OA\Property(property="tax", type="number", format="float"),
 *     @OA\Property(property="total_amount", type="number", format="float"),
 *     @OA\Property(property="status", type="string", enum={"pending", "paid", "cancelled"}),
 *     @OA\Property(property="payment_method", type="string"),
 *     @OA\Property(property="notes", type="string"),
 *     @OA\Property(property="paid_at", type="string", format="datetime"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Inventory",
 *     required={"device_id", "quantity", "status"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="device_id", type="integer"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="status", type="string", enum={"in_stock", "out_of_stock", "low_stock"}),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     required={"first_name", "last_name", "email"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="date_of_birth", type="string", format="date"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}),
 *     @OA\Property(property="role", type="string", enum={"admin", "customer", "staff"}),
 *     @OA\Property(property="is_active", type="boolean"),
 *     @OA\Property(property="email_verified_at", type="string", format="datetime"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="OrderItem",
 *     required={"order_id", "device_id", "quantity", "unit_price", "subtotal"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="device_id", type="integer"),
 *     @OA\Property(property="quantity", type="integer"),
 *     @OA\Property(property="unit_price", type="number", format="float"),
 *     @OA\Property(property="subtotal", type="number", format="float"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Category",
 *     required={"name", "slug"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="image", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", default=true),
 *     @OA\Property(property="parent_id", type="integer", nullable=true),
 *     @OA\Property(property="order", type="integer", default=0),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Property(
 *         property="devices",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Device")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 *
 * @OA\Schema(
 *     schema="Device",
 *     required={"name", "category_id", "price", "stock"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(
 *         property="category",
 *         ref="#/components/schemas/Category"
 *     ),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="stock", type="integer"),
 *     @OA\Property(property="image", type="string", nullable=true, description="Path to device image"),
 *     @OA\Property(property="created_at", type="string", format="datetime"),
 *     @OA\Property(property="updated_at", type="string", format="datetime")
 * )
 */
class ModelSchemas
{
    // This is an empty class that only contains Swagger annotations
    // No implementation needed
}
