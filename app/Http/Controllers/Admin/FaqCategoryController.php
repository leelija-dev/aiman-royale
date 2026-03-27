<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App\Models\FaqCategory;
use App\Models\FaqCategory as ModelsFaqCategory;

class FaqCategoryController extends Controller
{
    //
    public function index()
    {
        $faqCategories = ModelsFaqCategory::where('is_active', 1)->pluck('id', 'category_name');
        return view('Admin.faqCategory.index', compact('faqCategories'));
    }

    public function create(){
        
        return view('Admin.faqCategory.create');
    }
}
