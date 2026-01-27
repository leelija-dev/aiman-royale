<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Page;
use App\Models\Components;

// use App\Services\Service;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContentController extends Controller implements HasMiddleware
{


    public static function middleware()
    {
        return [
            new Middleware('permission:view page', only: ['index']),
            new Middleware('permission:edit page', only: ['edit']),
            new Middleware('permission:create page', only: ['create']),
            new Middleware('permission:delete page', only: ['delete']),
        ];
    }
    public function index()
    {
        $pages = Page::has('service')->with(['service' => function ($query) {
            $query->select('id', 'name');
        }])->get();
        return view('Admin.page.index', compact('pages'));
    }

    public function showCreateForm()
    {
        $services = Service::all();
        $pages = Page::all();
        // dd($pages);  
        return view('Admin.page.create', compact('services', 'pages'));
    }

    public function create(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'service' => 'required|integer ',
            'meta_title' => 'required|string',
            'meta_keyword' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'meta_description' => 'required|string',
            'schema' => 'nullable',
            'status' => 'required',
        ]);

        $data = [
            'service_id' => $request->input('service'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
            'meta_tags' => $request->input('meta_tags'),
            'meta_description' => $request->input('meta_description'),
            'schema'  => $request->input('schema'),
            'status'  => $request->input('status')
        ];


        try {
            $page = Page::create($data);
            $pageId = $page->page_id;

            $sections = $request->input('sections');
            // dd($sections);
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    $component_data = [
                        'component_name' => 'methodology',
                        'title'          => $section['title'],
                        'cards_data'          => json_encode($section['cards']),
                        'page_id'        => $pageId

                    ];
                    $components = Components::create($component_data);
                }
            }
            // $component_data['page_id'] = $pageId;

            return redirect()->route('admin.pages')->with('success', 'Page Created');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function showeditform($id)
    {
        //    dd($id);
        // $page = Page::findOrFail($id);
        // $page = Page::with('components')->findOrFail($id);
        // $services = Service::all();
        // $allpage = Page::all();
        // //  dd($page); 
        // return view('Admin.page.edit', compact('page', 'allpage', 'services'));

        $page = Page::with('components')->findOrFail($id);
        $services = Service::all();
        $allpage = Page::all();
        // Assuming you want the first component's data for editing
        // $component = $page->components->first(); // or loop for multiple components
        $components = $page->components;
        // dd($component);
        $sections = json_decode($components);
        $sectionsData = json_decode($components);
        // $sections = json_decode($component->cards_data ?? '[]', true);


        return view('Admin.page.edit', compact('page', 'allpage', 'services', 'components', 'sectionsData', 'sections'));
    }
    // public function edit(Request $request, $id)
    // {
    //     // dd($request);
    //     $page = Page::findOrFail($id);

    //     // Validate input
    //     $request->validate([
    //         'meta_title' => 'required|string',
    //         'meta_description' => 'required|string',
    //         'meta_keyword' => 'nullable|string',
    //         'meta_tags' => 'nullable|string',
    //     ]);

    //     $page->meta_title = $request->meta_title;
    //     $page->meta_description = $request->meta_description;
    //     // $page->page_title = $request->page_title;
    //     $page->meta_keyword = $request->meta_keyword;
    //     $page->meta_tags = $request->meta_tags;
    //     // $page->alt =  $request->alt;
    //     $page->schema = $request->schema;
    //     $page->status = $request->status;
    //     $page->service_id = $request->service;

    //     $page->save();

    //     // $component = Components::where('page_id', $page->page_id)->first();
    //     $components = Components::where('page_id', $page->page_id)->get();
    //     // dd($component);
    //     if ($components) {
    //         foreach ($components as $component) {
    //             $component->title = $request->section_title;
    //             $component->cards_data = json_encode($request->cards);
    //             $component->save();
    //         }
    //         // $component->title = $request->section_title;
    //         // $component->cards_data = json_encode($request->cards);
    //         // $component->save();
    //     } else {

    //         $sections = $request->sections;
    //         // dd($sections);
    //         foreach ($sections as $section) {
    //             $component_data = [
    //                 'component_name' => 'methodology',
    //                 'title'          => $section['title'],
    //                 'cards_data'          => json_encode($section['cards']),
    //                 'page_id'        => $page->page_id

    //             ];
    //             $components = Components::create($component_data);
    //         }
    //         // If component not exists, you can create it
    //         // Components::create([
    //         //     'page_id' => $page->page_id,
    //         //     'component_name' => 'methodology', // or any default
    //         //     'order' => 0,
    //         //     'title' => $request->section_title,
    //         //     'cards_data' => json_encode($request->cards),
    //         // ]);
    //     }

    //     return redirect()->route('admin.pages')
    //         ->with('success', 'Page updated successfully!');
    // }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $page = Page::findOrFail($id);

        // Validate input
        $request->validate([
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'nullable|string',
            'meta_tags' => 'nullable|string',
        ]);

        // Update Page Meta Fields
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keyword = $request->meta_keyword;
        $page->meta_tags = $request->meta_tags;
        $page->schema = $request->schema;
        $page->status = $request->status;
        $page->service_id = $request->service;

        $page->save();

        // Handling Components (Sections)
        $sections = $request->sections;  // Array of sections with title & cards

        // Fetch existing components for the page
        $existingComponents = Components::where('page_id', $page->page_id)->get();

        // Update existing components
        foreach ($existingComponents as $index => $component) {
            if (isset($sections[$index])) {
                $component->title = $sections[$index]['title'];
                $component->cards_data = json_encode($sections[$index]['cards']);
                $component->save();
                unset($sections[$index]); // Remove processed section
            } else {
                // If section is removed from form, delete the component
                $component->delete();
            }
        }

        // Add any new sections (remaining in $sections)
        if (!empty($sections)) {
            foreach ($sections as $section) {
                Components::create([
                    'component_name' => 'methodology',
                    'title'          => $section['title'],
                    'cards_data'     => json_encode($section['cards']),
                    'page_id'        => $page->page_id
                ]);
            }
        }

        return redirect()->route('admin.pages')->with('success', 'Page updated successfully!');
    }

    public function delete($id)
    {
        // dd($id);
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages')
            ->with('success', 'Page Deleted successfully!');
    }

    //   public function componentDelete($id)
    // {
    //     // dd($id);
    //     $component = Components::findOrFail($id);
    //     $component->delete();
    // }

    public function componentDelete($id)
    {
        $component = Components::findOrFail($id);
        $component->delete();

        return response()->json([
            'success' => true,
            'message' => 'Component deleted successfully.'
        ]);
    }
}
