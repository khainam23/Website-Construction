<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Invoices",
 *     description="API Endpoints for managing invoices"
 * )
 */
class InvoiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/invoices",
     *     summary="Get all invoices",
     *     tags={"Invoices"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all invoices",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Invoice")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Invoice::with('user')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/invoices",
     *     summary="Create a new invoice",
     *     tags={"Invoices"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","subtotal","tax","total_amount","payment_method","items"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="subtotal", type="number", format="float"),
     *             @OA\Property(property="tax", type="number", format="float"),
     *             @OA\Property(property="total_amount", type="number", format="float"),
     *             @OA\Property(property="payment_method", type="string"),
     *             @OA\Property(property="notes", type="string"),
     *             @OA\Property(property="items", type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Invoice created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Invoice")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array'
        ]);

        // Generate unique invoice number
        $validated['invoice_number'] = 'INV-' . Str::random(10);
        
        $invoice = Invoice::create($validated);

        return response()->json($invoice, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/invoices/{id}",
     *     summary="Get invoice details",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invoice details",
     *         @OA\JsonContent(ref="#/components/schemas/Invoice")
     *     )
     * )
     */
    public function show($id)
    {
        $invoice = Invoice::with(['user'])->findOrFail($id);
        return response()->json($invoice);
    }

    /**
     * @OA\Put(
     *     path="/api/invoices/{id}/mark-as-paid",
     *     summary="Mark invoice as paid",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invoice marked as paid",
     *         @OA\JsonContent(ref="#/components/schemas/Invoice")
     *     )
     * )
     */
    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);
        return response()->json($invoice);
    }

    /**
     * @OA\Post(
     *     path="/api/invoices/generate-from-sale/{sale}",
     *     summary="Generate invoice from sale",
     *     tags={"Invoices"},
     *     @OA\Parameter(
     *         name="sale",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Invoice generated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Invoice")
     *     )
     * )
     */
    public function generateFromSale(Sale $sale)
    {
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . Str::random(10),
            'user_id' => $sale->user_id,
            'subtotal' => $sale->total_price,
            'tax' => $sale->total_price * 0.1, // 10% tax example
            'total_amount' => $sale->total_price * 1.1,
            'status' => 'pending',
            'notes' => 'Invoice for sale #' . $sale->id
        ]);

        return response()->json($invoice, 201);
    }
}
