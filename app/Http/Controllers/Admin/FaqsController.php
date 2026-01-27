<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQs;
use App\Models\Service;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class FaqsController extends Controller
{
    public function index()
    {
        try {

            $faqs = FAQs::with(['page' => function ($query) {
                $query->select('page_id', 'service_id', 'meta_title');
            }])
                ->groupBy('page_id')
                ->selectRaw('page_id, COUNT(*) as total')
                ->get();

            return view('Admin.faqs.index', compact('faqs',));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::error('Error fetching FAQs index: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $pages = Page::all();
            $data = FAQs::findorFail($id);
            return view('Admin.faqs.view_question', compact('data', 'pages'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }

    public function showFAQs()
    {
        try {
            $page_title = Page::all();
            // dd($page_title);
            return view('Admin.faqs.add_faqs', compact('page_title'));
        } catch (\Exception $e) {
            Log::error('Error fetching FAQs : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }
    
    public function addFAQs(Request $request)
    {
        try {
            $data = $request->validate([
                'page_id' => 'string',
                'question' => 'string',
                'answer' => 'string',

            ]);
            // dd($data);
            $status = $request->has('status') ? '1' : '0';
            $data['status'] = $status;
            // $plainText = strip_tags($data['answer']);
            // $data['answer'] = $plainText;
            FAQs::create($data);
            return redirect()->route('faq.list')->with('sucsess', 'Faqs added successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }

    public function pagewiseQuestions($service)
    {
        try {
            $data = FAQs::where('page_id', $service)->get();
            return view('Admin.faqs.service_faqs', compact('data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }

    public function editQuestion(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'question' => 'required|string',
                'answer' => 'required|string',
                'page_id' => 'required|integer',

            ]);
            $status = $request->has('status') ? '1' : '0';
            $data['status'] = $status;
            // $plainText = strip_tags($data['answer']);
            // $data['answer'] = $plainText;
            FAQs::where('id', $id)->update($data);
            $service = FAQs::findorFail($id);

            return redirect()->route('faq.all-question', ['page_id' => $request->input('page_id')])->with('sucsesss', 'FAQs Updated Successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }

    public function deleteQuestion($id)
    {
        try {
            $service = FAQs::findorFail($id);
            FAQs::findorFail($id)->delete();

            return redirect()->route('faq.all-question', ['service' => $service->service])->with('sucsesss', 'FAQs question Deleted Successfully');
        } catch (\Exception $e) {
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading FAQs.');
        }
    }
}
