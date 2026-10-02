<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FalseReview;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reviews = FalseReview::with('product')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('web.reviews', compact('reviews'));
    }
}
