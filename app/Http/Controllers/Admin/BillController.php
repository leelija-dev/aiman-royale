<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\PaymentHistory;
use App\Models\Shop;
use App\Models\Stock;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function index()
    {
        // Fetch active products with their brand, unit, and stock relationships
        // $products = Product::with(['brand', 'unit', 'stocks'])
        //     ->where('is_active', true)
        //     ->get()    
        //     ->map(function ($product) {
        //         // Check if unit relationship is loaded and has name, otherwise fallback to unit column
        //         $unitName = $product->unit ?
        //             (is_object($product->unit) ? $product->unit->code : $product->unit) : ($product->unit ?? 'pcs');

        //         // Calculate total stock quantity
        //         $stockQuantity = $product->stocks->sum('quantity_in_stock');

        //         return [
        //             'id' => $product->id,
        //             'name' => $product->name,
        //             'price' => (float) $product->price,
        //             'sku' => $product->sku,
        //             'company' => $product->brand ? $product->brand->name : 'N/A',
        //             'unit_amount' => $product->unit_amount,
        //             'unit' => $unitName,
        //             'stock_quantity' => (int) $stockQuantity,
        //             'stocks' => $product->stocks->map(function ($stock) {
        //                 return [
        //                     'id' => $stock->id,
        //                     'purchase_price' => (float) $stock->purchase_price,
        //                     'selling_price' => (float) $stock->selling_price,
        //                     'quantity_in_stock' => (int) $stock->product_package_quantity,
        //                     'unit_amount' => (float) $stock->unit_amount,
        //                     'unit_id' => $stock->unit_id,
        //                     'created_at' => $stock->created_at,
        //                     'updated_at' => $stock->updated_at
        //                 ];
        //             })
        //         ];
        //     });
        // // dd($products);
        $products = Product::with(['brand' => function ($b) {
        $b->withTrashed();
        }, 'category' =>function ($c){
        $c->withTrashed();
        }, 
        'unit', 'stocks'])
            ->where('is_active', true)
            ->get()
            ->flatMap(function ($product) {
                $unitName = $product->unit ?
                    (is_object($product->unit) ? $product->unit->code : $product->unit) : ($product->unit ?? 'pcs');

                return $product->stocks->map(function ($stock) use ($product, $unitName) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (float) $product->price,
                        'purchase_price' => (float) $stock->purchase_price,
                        'sku' => $product->sku,
                        'company' => $product->brand ? $product->brand->name : 'Other',
                        'category' => $product->category ? $product->category->name : 'Other',
                        'unit_amount' => $product->unit_amount,
                        'unit' => $unitName,
                        'stock_quantity' => (float) $stock->product_package_quantity,
                        'stocks' => collect([[
                            'id' => $stock->id,
                            'purchase_price' => (float) $stock->purchase_price,
                            'selling_price' => (float) $stock->selling_price,
                            'quantity_in_stock' => (float) $stock->product_package_quantity,
                            'stock_quantity_unit' => $stock->unit->code,
                            'unit_amount' => (float) $stock->unit_amount,
                            'unit_id' => $stock->unit_id,
                            'created_at' => $stock->created_at,
                            'updated_at' => $stock->updated_at
                        ]])
                    ];
                });
            });

    //    dd($products);
        $customer = Shop::all();
        return view('Admin.bill.index', [
            'products' => $products,
            'customers' => $customer
        ]);

        // $products = Product::with([
        //     'brand',
        //     'unit',
        //     'stocks.histories' // include stock histories
        // ])
        //     ->where('is_active', true)
        //     ->get()
        //     ->map(function ($product) {
        //         $unitName = $product->unit ?
        //             (is_object($product->unit) ? $product->unit->code : $product->unit) : ($product->unit ?? 'pcs');

        //         // total available stock
        //         $stockQuantity = $product->stocks->sum('quantity_in_stock');
        //         // dd($product);
        //         return [
        //             'id' => $product->id,
        //             'name' => $product->name,
        //             'price' => (float) $product->price,
        //             'sku' => $product->sku,
        //             'company' => $product->brand ? $product->brand->name : 'N/A',
        //             'unit_amount' => $product->unit_amount,
        //             'unit' => $unitName,
        //             'stock_quantity' => (int) $stockQuantity,
        //             'stocks' => $product->stocks->map(function ($stock) {
        //                 // get latest stock history for purchase/selling price
        //                 $latestHistory = $stock->histories->sortByDesc('created_at')->first();

        //                 return [
        //                     'id' => $stock->id,
        //                     'purchase_price' => (float) ($latestHistory->purchase_price ?? $stock->purchase_price ?? 0),
        //                     'selling_price' => (float) ($latestHistory->selling_price ?? $stock->selling_price ?? 0),
        //                     'quantity_in_stock' => (int) $stock->product_package_quantity,
        //                     'unit_amount' => (float) $stock->unit_amount,
        //                     'unit_id' => $stock->unit_id,
        //                     'created_at' => $stock->created_at,
        //                     'updated_at' => $stock->updated_at
        //                 ];
        //             })
        //         ];
        //     });

        // $customer = Shop::all();
        // return view('Admin.bill.index', [
        //     'products' => $products,
        //     'customers' => $customer
        // ]);
    }

    public function store(Request $request)
    {

        
 
        $request->validate([
            'customer_id' => 'required|exists:shops,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:0',
            'items.*purchase_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.subtotal' => 'required|numeric|min:0|max:99999999.99',
            'total_amount' => 'required|numeric|min:0|max:99999999.99',
            'semi_paid_amount' => 'nullable|numeric|min:0|max:99999999.99',
            //'discount_percent' => 'nullable|numeric|min:0|max:100',
            //'discount_amount' => 'nullable|numeric|min:0',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get the next bill number (simple auto-incrementing integer)
            // $lastInvoice = DB::table('invoice')->latest('id')->first();
            // $billNumber = $lastInvoice ? $lastInvoice->bill_id + 1 : 1;

            $totalItems = array_sum(array_column($request->items, 'quantity'));
            $totalAmount = $request->total_amount;
            

            // Get the authenticated admin user ID
            $adminId = null;

            // Try different methods to get the admin ID
            if (auth('admin')->check()) {
                $adminId = auth('admin')->id();
            } elseif (session()->has('admin_user_id')) {
                $adminId = session('admin_user_id');
            } else {
                // Fallback: Get the first admin user from the database
                $adminUser = DB::table('admin_users')->select('id')->first();
                if ($adminUser) {
                    $adminId = is_object($adminUser) ? $adminUser->id : $adminUser['id'];
                } else {
                    // Last resort: Use a default admin ID
                    $adminId = 1;
                }
            }

            // Ensure we have a valid admin ID
            if (!$adminId) {
                throw new \Exception('Could not determine admin user ID');
            }
            $payment_status = $request->payment_status;
            $paid_amount = 0;
            if ($payment_status == 'paid') {

                $paid_amount = $totalAmount;
            } elseif ($payment_status == 'semi_paid') {
                if ($request->semi_paid_amount >= $totalAmount) {
                    echo "invalid paid amount";
                    exit();
                } else {
                    $paid_amount = $request->semi_paid_amount;
                }
            } elseif ($payment_status == 'non_paid') {
                $paid_amount = 0;
            } else {
                echo "invalid paid amount";
            }



            // Calculate due amount
            $dueAmount = 0;
            if ($payment_status === 'semi_paid') {
                $dueAmount = $totalAmount - $paid_amount;
            } elseif ($payment_status === 'non_paid') {
                $dueAmount = $totalAmount;
                $paid_amount = 0; // Ensure paid_amount is 0 for non-paid bills
            }
            $shop = Shop::find($request->customer_id);
            $lastInvoiceId = Invoice::max('id');
            $payment_history = [
                'shop_id' => $request->customer_id,
                'paid_amount' => $paid_amount,
                'due_amount' => $totalAmount - $paid_amount,
                'payment_from' => 'Payment received against bill number ' . $lastInvoiceId + 1,
            ];
            if($payment_history['due_amount'] >99999999.99 || $payment_history['paid_amount'] > 99999999.99){
                return "total amount cannot be greater than 99999999.99";
            }
            try{
            PaymentHistory::create($payment_history);
            }
            catch(\Exception $e){
                echo $e->getMessage();
                exit();
            }
            try{
            // 1. Create the invoice record first
            $invoiceId = DB::table('invoice')->insertGetId([
                'shop_id' => $request->customer_id,
                'paid_amount' => $paid_amount,
                'bill_date' => now(),
                'total_amount' => $totalAmount ,
                //'discount_amount' => $request->discount_amount,
                'total_items' => $totalItems,
                //'discount' => $request->discount_percent,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            }
            catch(\Exception $e){
                echo $e->getMessage();  
                exit();
            }

            // Update shop's due amount if payment is not fully paid
            if ($payment_status !== 'paid' && $dueAmount > 0) {
                $shop = Shop::find($request->customer_id);
                if ($shop) {
                    $currentDueAmount = (float)($shop->due_amount ?? 0);
                    $shop->update([
                        'due_amount' => $currentDueAmount + $dueAmount
                    ]);
                }
            }

            // 2. Prepare bill items with the same invoice ID
            $billItems = [];
            foreach ($request->items as $item) {
                // $category = DB::table('products')
                //     ->join('categories', 'products.category_id', '=', 'categories.id')
                //     ->where('products.id', $item['product_id'])
                //     ->select('categories.name as category_name') // select what you need
                //     ->first();

                $category = DB::table('products')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->where('products.id', $item['product_id'])
                    ->value('categories.name'); // gets the category name directly




                // Combine unit_amount and unit for display in quantity field
                $quantityDisplay = $item['quantity'];
                if (isset($item['unit_amount'])) {
                    $quantityDisplay = $item['unit_amount'] . ' ' . ($item['unit'] ?? 'pcs');
                }
                
                $billItems[] = [
                    'invoice_id' => $invoiceId, // This should be the auto-incremented ID from the invoice table
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'] ?? null,
                    'brand' => $item['brand'] ?? null,
                    'category' => $item['category'] ?? 'category',
                    'quantity' => $item['quantity'], //$quantityDisplay(L), 
                    'quantity_unit' => $item['stock_unit'],
                    'purchase_price' => $item['purchase_price'],
                    'unit_price' => $item['price'],
                    'total_amount' => $item['subtotal'],
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 3. Insert all bill items at once
            try{
            if (!empty($billItems)) {
                DB::table('invoice_items')->insert($billItems);

                // 4. Update stock quantities
                foreach ($request->items as $item) {
                    
                    // Find the stock record for this product
                    $stock = Stock::where('product_id', $item['product_id'])
                    //->where('selling_price', $item['price'])
                    ->where('purchase_price', $item['purchase_price'])
                    ->first();

                    if ($stock) {
                        // Decrease the stock quantity
                        $newQuantity = $stock->product_package_quantity - $item['quantity'];

                        // Ensure stock doesn't go below zero
                        if ($newQuantity < 0) {
                            throw new \Exception("Insufficient stock for product: " . $item['name']);
                        }

                        // Update the stock
                        $stock->update([
                            'product_package_quantity' => $newQuantity
                        ]);
                    }
                }
            }
            }catch(\Exception $e){
                echo $e->getMessage();
                exit(); 
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bill saved successfully',
                'bill_number' => $invoiceId,
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error saving bill: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save bill: ' . $e->getMessage(),
            ], 500);
        }
    }
}
