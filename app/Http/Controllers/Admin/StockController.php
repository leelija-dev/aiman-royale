<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\ProductPackageType;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\StockHistory;
use App\Models\ProductVariant;
use App\Models\StockIn;
use Illuminate\Http\Request;


class StockController extends Controller
{
    // public function index(Request $request)
    // {   
    //     $search = $request->input('search');
    //     $query = Stock::with(['product', 'packageType', 'unit'])
    //         ->latest();
    //         //->paginate(10);

    //     if (!empty($search)) {
    //     $query->where(function ($q) use ($search) {
    //         // Search by product name
    //         $q->whereHas('product', function ($sub) use ($search) {
    //             $sub->where('name', 'like', '%' . $search . '%');
    //         })
    //         //Search by package type 
    //         ->orWhereHas('packageType', function ($sub) use ($search) {
    //             $sub->where('package_type', 'like', '%' . $search . '%');
    //         });
    //     });
    //     }

    //     $stocks = $query->paginate(10);
        
    //     return view('Admin.stocks.index', compact('stocks'));
    // }
    public function index(Request $request)
{   
    $search = $request->input('search');

    // Load related product with its brand (including soft-deleted) and unit
    $query = Stock::with([
        'product' => function ($q) {
            $q->withTrashed()->with(['brand' => function ($b) { $b->withTrashed(); }]);
        },
        'unit',
    ])->latest();


    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            // Search by product name
            $q->whereHas('product', function ($sub) use ($search) {
                $sub->withTrashed()->where(function ($p) use ($search) {
                    $p->where('name', 'like', '%' . $search . '%')
                      ->orWhere('sku', 'like', '%' . $search . '%');
                });
            })
            // Search by unit name or code
            ->orWhereHas('unit', function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        });
    }

    $stocks = $query->paginate(10);
    
    return view('Admin.stocks.index', compact('stocks'));
}


    public function create()
    {
        $products = Product::active()->get();
        //$packageTypes = ProductPackageType::active()->get();
        $units = Unit::all();
        $brands=Brand::withTrashed()->get();
        $category=Category::withTrashed()->get();

        return view('Admin.stocks.create', compact('products', 'units','brands','category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'product_id' => 'required|exists:products,id',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0|gt:purchase_price',
                'product_package_id' => 'required|exists:units,id',
                'product_package_quantity' => 'required|integer|min:1',
                //'unit_amount' => 'required|numeric|min:0',
                //'unit_id' => 'required|exists:units,id'
            ],
            [
                'product_id.required' => 'Please select a product',
                'product_package_id.required' => 'Please select a package type',
                'product_package_quantity.required' => 'Please enter package quantity',
                'product_package_quantity.min' => 'Quantity must be at least 1',
                'purchase_price.required' => 'Purchase price is required',
                'purchase_price.min' => 'Price cannot be negative',
                'selling_price.required' => 'Selling price is required',
                'selling_price.gt' => 'Selling price must be greater than purchase price',
            ]
        );

        try {
            DB::beginTransaction();

            // Check if stock with same product and package already exists
            $existingStock = Stock::where('product_id', $validated['product_id'])
                ->where('product_package_id', $validated['product_package_id'])
                ->where('selling_price', $validated['selling_price'])
                 ->where('purchase_price', $validated['purchase_price'])
                ->first();

            if ($existingStock) {
                DB::rollBack();
                return redirect()
                    ->route('stocks.edit', $existingStock->id)
                    ->with('error', 'A stock entry with this product and package combination already exists. Please update the existing entry instead of creating a new one.');
            }

            // Create new stock entry
            $stock = Stock::create([
                'product_id' => $validated['product_id'],
                'purchase_price' => $validated['purchase_price'],
                'selling_price' => $validated['selling_price'],
                'product_package_id' => $validated['product_package_id'],
                'product_package_quantity' => $validated['product_package_quantity'],
                // 'quantity_in_stock' => 0, // Initialize with 0 quantity
                //'unit_id' => $validated['unit_id'],
                //'unit_amount' => $validated['unit_amount']
            ]);
            // $stockId = $stock->id;
            StockHistory::create([
                'stock_id' => $stock->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['product_package_quantity'],
                'remaining_quantity' => $validated['product_package_quantity'],
                'purchase_price' => $validated['purchase_price'],
                'selling_price' => $validated['selling_price'],
            ]);

            DB::commit();

            return redirect()
                ->route('stocks.index')
                ->with('success', 'Stock added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to add stock: ' . $e->getMessage());
        }
    }

    public function edit(Stock $stock)
    {
        $products = Product::withTrashed()->active()->get();
         $stock->load([
        'product' => fn($p) => $p->withTrashed()->with([
            'brand' => fn($b) => $b->withTrashed(),
            'category' => fn($c) => $c->withTrashed(),
        ]),
    ]);
        //$packageTypes = ProductPackageType::active()->get();
        $units = Unit::all();

        return view('Admin.stocks.edit', compact('stock', 'products', 'units'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate(
            [
                'product_package_id' => 'required',
                //'unit_id' => 'required',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'product_package_quantity' => 'required|integer|min:1',
                //'unit_amount' => 'required|numeric|min:0',
                //'unit_id' => 'required|exists:units,id'
            ],
            [
                'product_id.required' => 'Please select a product',
                'product_package_id.required' => 'Please select a package type',
                'product_package_quantity.required' => 'Please enter package quantity',
                'product_package_quantity.min' => 'Quantity must be at least 1',
                'purchase_price.required' => 'Purchase price is required',
                'purchase_price.min' => 'Price cannot be negative',
                'selling_price.required' => 'Selling price is required',
                'selling_price.gt' => 'Selling price must be greater than purchase price',
            ]
        );

        try {
            $stock->update($validated);
            return redirect()->route('stocks.index')
                ->with('success', 'Stock updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update stock: ' . $e->getMessage());
        }
    }

    public function destroy(Stock $stock)
    {
        try {
            $stock->delete();
            //return response()->json(['success' => true]);
            return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully!');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // public function addStock(Request $request, Stock $stock)
    // {
      
    //     $validator = \Validator::make($request->all(), [
    //         'quantity' => 'required|integer|min:1',
    //     ], [
    //         'quantity.required' => 'Please enter quantity',
    //         'quantity.integer' => 'Quantity must be a whole number',
    //         'quantity.min' => 'Quantity must be at least 1',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Start database transaction
    //     DB::beginTransaction();

    //     try {
    //         // Update the stock
    //         $stock->updateStock($request->quantity, 'in');
          
    //         dd($stock);
            
    //         // Create stock history record
    //         StockHistory::create([
    //             'stock_id' => $stock->id,
    //             'product_id' => $stock->product_id,
    //             'quantity' => $request->quantity,
    //             'remaining_quantity' => $request->quantity,
    //             'purchase_price' => $stock->purchase_price,
    //             'selling_price' => $stock->selling_price,
    //             'transaction_type' => 'in',
    //             'notes' => 'Stock added manually',
    //             'created_by' => auth()->id(),
    //             'updated_by' => auth()->id(),
    //         ]);

    //         // Update the stock's purchase and selling prices
    //         $stock->update([
    //             'purchase_price' => $request->purchase_price,
    //             'selling_price' => $request->selling_price,
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Stock added successfully!',
    //             'new_quantity' => $stock->fresh()->quantity_in_stock
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::error('Failed to add stock: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to add stock: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function addStock(Request $request, Stock $stock)
{
    $validator = \Validator::make($request->all(), [
        'quantity' => 'required|integer|min:1',
    ], [
        'quantity.required' => 'Please enter quantity',
        'quantity.integer' => 'Quantity must be a whole number',
        'quantity.min' => 'Quantity must be at least 1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();

    try {
        // Refresh the stock from DB to make sure prices are up to date
        $stock = Stock::findOrFail($stock->id);

        // Update the stock quantity
        $stock->updateStock($request->quantity, 'in');

        // Create a history entry with the correct prices
        StockHistory::create([
            'stock_id' => $stock->id,
            'product_id' => $stock->product_id,
            'quantity' => $request->quantity,
            'purchase_price' => $stock->purchase_price,
            'selling_price' => $stock->selling_price,
            'transaction_type' => 'in',
            'notes' => 'Stock added manually',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Optionally update prices if user provided them
        if ($request->has('purchase_price') || $request->has('selling_price')) {
            $stock->update([
                'purchase_price' => $request->purchase_price ?? $stock->purchase_price,
                'selling_price' => $request->selling_price ?? $stock->selling_price,
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Stock added successfully!',
            'new_quantity' => $stock->fresh()->quantity_in_stock,
            'purchase_price' => $stock->purchase_price,
            'selling_price' => $stock->selling_price,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Failed to add stock: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to add stock: ' . $e->getMessage()
        ], 500);
    }
}


    public function deductStock(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($stock) {
                    if ($value > $stock->quantity_in_stock) {
                        $fail('Deduction quantity cannot be greater than available stock.');
                    }
                },
            ],
        ]);

        try {
            $stock->updateStock($validated['quantity'], 'out');
            return back()->with('success', 'Stock deducted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to deduct stock: ' . $e->getMessage());
        }
    }

    /**
     * Update stock for a product variant.
     */
    public function updateVariantStock(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'stock' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);
        
        // Calculate new total stock (current stock + added stock)
        $currentStock = $variant->stock;
        $addedStock = $request->stock;
        $newTotalStock = $currentStock + $addedStock;
        
        // Create new stock entry with the added amount
        StockIn::create([
            'product_variant_id' => $variant->id,
            'stock' => $addedStock, // Store the amount being added
        ]);

        // Update variant stock with the new total
        $variant->update(['stock' => $newTotalStock]);

        return redirect()->route('admin.product-variants')
            ->with('success', "Stock updated successfully for {$variant->sku}! Added {$addedStock} units to previous {$currentStock} units. New total: {$newTotalStock} units.");
    }
}
