<?php

// namespace App\Http\Controllers\web;

// use App\Http\Controllers\Controller;
// use App\Models\JobVacancy;
// use App\Models\Departments;
// use Illuminate\Http\Request;

// class CareerController extends Controller
// {
//     public function index(){
//         $data = JobVacancy::all();
//         $departments = Departments::where('status', 1)->get();
//         $experiences = JobVacancy::select('exprience')
//             ->whereNotNull('exprience')
//             ->where('exprience', '!=', '')
//             ->get()
//             ->map(function($item) {
//                 // Normalize the experience string
//                 $exp = trim(strtolower($item->exprience));
//                 // Remove 's' from 'years' and trim any extra spaces
//                 $exp = str_replace('years', 'year', $exp);
//                 $exp = str_replace('  ', ' ', $exp);
//                 // Extract numbers and words separately
//                 if (preg_match('/(\d+)\s*(year|yr|y)/', $exp, $matches)) {
//                     $number = $matches[1];
//                     return $number . ' year' . ($number > 1 ? 's' : '');
//                 }
//                 return $exp;
//             })
//             ->unique()
//             ->sort()
//             ->values();
            
//         return view('web.career', [
//             'data' => $data,
//             'departments' => $departments,
//             'experiences' => $experiences
//         ]);
//     }
    
// }
