<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\OfferProducts;
use App\Models\ProductVariant;

class OfferController extends Controller
{
    public function index()
    {
        $search = request('search');
        $offers = Offer::orderBy('id', 'desc')
            ->where('name', 'like', "%$search%")
            ->orWhere('discount', 'like', "%$search%")
            ->orWhere('start_date', 'like', "%$search%")
            ->orWhere('end_date', 'like', "%$search%")
            ->orWhere('duration', 'like', "%$search%")
            ->orWhere('apply_on', 'like', "%$search%")
            ->paginate(10);
        return view('Admin.offer.index', compact('offers'));
    }
    public function create()
    {
        $productVariants = ProductVariant::all();
        return view('Admin.offer.create', compact('productVariants'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discount' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required|integer',
            'apply_on' => 'required',
            'is_active' => 'required',
            'is_timer' => 'nullable',
            'product_id' => 'nullable|array',
            'product_variant_id' => 'nullable|array',
        ]);

        try {

            if ($request->boolean('is_timer')) {
                Offer::query()->update([
                    'is_timer' => false
                ]);
            }
            $offer = Offer::create([
                'name' => $request->name,
                'discount' => $request->discount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'duration' => $request->duration,
                'apply_on' => $request->apply_on,
                'is_active' => $request->is_active,
                'is_timer' => $request->is_timer
            ]);

            $allVariants = ProductVariant::all();
            // Store selected products

            if (
                $request->apply_on == "selected-product" &&
                $request->filled('selected_product_variants')
            ) {
                foreach ($request->product_variant_id as $key => $variantId) {

                    OfferProducts::create([
                        'offer_id' => $offer->id,
                        'product_id' => $request->product_id[$key],
                        'product_variant_id' => $variantId,
                    ]);
                }
            } else {
                foreach ($allVariants as  $variant) {
                    OfferProducts::create([
                        'offer_id'           => $offer->id,
                        'product_id'         => $variant->product_id,
                        'product_variant_id' => $variant->id,
                    ]);
                }
            }
            return redirect()
                ->route('offer.index')
                ->with('success', 'Offer created successfully');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $offer = Offer::where('id', $id)->with('offerProducts')->first();
        $productVariants = ProductVariant::all();
        return view('Admin.offer.edit', compact('offer', 'productVariants'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discount' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required|integer',
            'apply_on' => 'required',
            'is_active' => 'required',
            'is_timer' => 'nullable',
            'product_id' => 'nullable|array',
            'selected_product_variants' => 'nullable|array',
        ]);

        try {

            $offer = Offer::findOrFail($id);
            $offers = Offer::all();
            if ($data['is_timer'] == true) {
                Offer::where('id', '!=', $id)
                    ->update([
                        'is_timer' => false
                    ]);
            }
            $offer->update([
                'name'       => $request->name,
                'discount'   => $request->discount,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'duration'   => $request->duration,
                'apply_on'   => $request->apply_on,
                'is_active'  => $request->is_active,
                'is_timer'   => $request->has('is_timer') ? 1 : 0,
            ]);

            // Remove previous selected products
            OfferProducts::where('offer_id', $offer->id)->delete();
            $allVariantProduct = ProductVariant::all();
            // Store selected products only if apply_on is selected-product
            // dd($data);
            if (
                $request->apply_on == "selected-product" &&
                $request->filled('selected_product_variants')
            ) {
                // dd($request->product_variant_id);
                foreach ($request->selected_product_variants as $key => $variantId) {

                    OfferProducts::create([
                        'offer_id'           => $offer->id,
                        'product_id'         => $request->product_id[$key],
                        'product_variant_id' => $variantId,
                    ]);
                }
            } else {
                foreach ($allVariantProduct as $key => $variant) {
                    OfferProducts::create([
                        'offer_id'           => $offer->id,
                        'product_id'         => $variant->product_id,
                        'product_variant_id' => $variant->id,
                    ]);
                }
            }

            return redirect()
                ->route('offer.index')
                ->with('success', 'Offer updated successfully');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    public function delete($id)
{
    $offer = Offer::findOrFail($id);

    try {
        // Delete all products associated with this offer
        OfferProducts::where('offer_id', $offer->id)->delete();

        // Delete the offer
        $offer->delete();

        return redirect()
            ->route('offer.index')
            ->with('success', 'Offer deleted successfully');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
}
