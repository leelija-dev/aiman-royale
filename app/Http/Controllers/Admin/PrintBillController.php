<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Bill;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrintBillController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // single search field

        $query = Invoice::with([
            'items' => function($query) {
                $query->with(['product.unit'=> function($q) {
                        $q->select('id', 'name');
                    }
                ])->select('*');
            },
            'createdBy',
            'shop'
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Search by Bill ID or Shop ID
                if (is_numeric($search)) {
                    $q->orWhere('id', $search)
                      ->orWhereHas('shop', function($shopQuery) use ($search) {
                          $shopQuery->where('id', $search);
                      });
                }

                // Search by Date (YYYY-MM-DD)
                if (preg_match('/\d{4}-\d{2}-\d{2}/', $search)) {
                    $q->orWhereDate('bill_date', $search);
                }
                
                // Search by Shop Name
                $q->orWhereHas('shop', function ($shopQuery) use ($search) {
                    $shopQuery->where('shop_name', 'like', '%' . $search . '%');
                });
              
                        // Search for "unknown" shops (shop_id exists but shop record missing)
                if (strtolower($search) === 'unknown shop' || strtolower($search) ===  'unknown') {
                    $q->orWhereDoesntHave('shop');
                }
            
            });
        }

        $invoices = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->appends($request->all());

        // dd($invoices);
        return view('Admin.print-bill.index', compact('invoices'));
    
}


    public function getInvoice($id)
    {
        try {
            $invoice = Invoice::with(['items' => function($query) {
                $query->with(['product.unit' => function($q) {
                    $q->select('id', 'name');
                }])->select('id', 'invoice_id', 'product_id', 'product_name', 'product_sku', 'brand', 'quantity', 'unit_price', 'total_amount');
            }])->findOrFail($id);
            dd($invoice);

            // Format the invoice data for the receipt
            $formattedBill = [
                'id' => str_pad($invoice->id, 5, '0', STR_PAD_LEFT),
                'date' => $invoice->bill_date,
                'customer' => $invoice->customer_name ?: 'Walk-in Customer',
                'subtotal' => (float) $invoice->subtotal,
                'totalItems' => $invoice->total_items,
                'items' => $invoice->items->map(function($item) {
                    return [
                        'productId' => $item->product_id,
                        'productName' => $item->product_name,
                        'qty' => (float) $item->quantity,
                        'price' => (float) $item->unit_price,
                        'total' => (float) $item->total_amount,
                        'unit' => $item->product->unit->name ?? 'pcs',
                        'sku' => $item->product_sku,
                        'brand' => $item->brand
                    ];
                })
            ];

            Log::info('Successfully fetched invoice: ' . $invoice->id);

            return response()->json([
                'success' => true,
                'bill' => $formattedBill
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Invoice not found: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching invoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load bill details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::with(['items' => function($query) {
            $query->select('id', 'invoice_id', 'shop_id', 'product_name', 'product_sku', 'brand', 'quantity', 'unit_price', 'total_amount');
        }])->findOrFail($id);

        return view('Admin.print-bill.print', compact('invoice'));
    }
}