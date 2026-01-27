<?php

// namespace App\Http\Controllers\Web;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\FAQs;
// use Illuminate\Support\Facades\Log;
// use App\Models\Service;
// use App\Models\Page;

// class FaqController extends Controller
// {
//     public function showbySlug($slug)
//     {
//         try {

//             $faqs = FAQs::join('pages', 'faqs.page_id', '=', 'pages.page_id')
//                 ->join('services', 'pages.service_id', '=', 'services.id')
//                 ->where('services.slug', $slug)
//                 ->select('faqs.id', 'faqs.question', 'faqs.answer')
//                 ->where('faqs.status', '1')
//                 ->get();
            
//             return $faqs;
//         } catch (\Exception $e) {
//             dd($e->getMessage());
//             Log::error('Error fetching FAQs: ' . $e->getMessage());
//             return []; // or handle the error as needed
//         }
//     }
// }
