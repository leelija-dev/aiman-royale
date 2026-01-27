<!-- < ?php

namespace App\Http\Controllers\Web;
use App\Models\Page;
use App\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\MetaData;
use App\Models\PageDetails;
use App\Models\ComponentDetails;
use App\Models\Components;
use App\Models\ContactUs;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    
    public function sub_pages(Request $request,$slug)
    {
        
        switch ($slug) {
            case 'about-us':
                return view('about'); 

            case 'contact-us':

                if ($request->isMethod('post')){
                // dd($request->all());
                $request->validate([
                    'contact_name' => 'required|string|min:3|max:255',
                    'contact_email' => 'required|email',
                    'contact_phone' => 'required|digits:10',
                    'message' => 'required|string|min:10|max:200'
                ]);
                //  dd($request->all());
                ContactUs::create([
                    'contact_name' => $request->contact_name,
                    'contact_email' => $request->contact_email,
                    'contact_phone' => $request->contact_phone,
                    'message' => $request->message,
                    'added_on'=> now()
                ]);
                // dd($request->all());
                logger($request->all());
                return redirect()->back()->with('message', 'Thank you for contacting us!');
        
            }
            return view('contact');
                

            default:

            $page = Page::where('slug', $slug)->first();
            // dd($page->id); 
            if ($page) {
                
                $pageDetails = PageDetails::where('page_id', $page->id)->get(); 
                $componentDetails= ComponentDetails::where('page_id',$page->id)->get();
                $metaData= MetaData::where('page_id',$page->id)->get();
                // dd($pageDetails); 
                return view('common', [
                    'page' => $page,
                    'pageDetails' => $pageDetails,
                    'ComponentDetails' => $componentDetails,
                    'metaData' => $metaData
                ]);
            } else {
                abort(404);
            }
        }
    }

     public function showbySlug($slug)
    {
        try {

            $components = Components::join('pages', 'components.page_id', '=', 'pages.page_id')
                ->join('services', 'pages.service_id', '=', 'services.id')
                ->where('services.slug', $slug)
                ->select('components.id', 'components.title', 'components.cards_data')
              
                ->get();
            
            return $components;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error fetching FAQs: ' . $e->getMessage());
            return []; // or handle the error as needed
        }
    }
    

    /**
     * Get page details by service slug
     *
     * @param string $slug
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function pageMetaSlug(string $slug)
    {
        try {
            $page = Page::with('service')
                ->whereHas('service', function($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->firstOrFail();

            $response = ['status' => true, 'data' => $page];
            return response($response, 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $response = ['status' => false, 'message' => 'Page not found.'];

            return response($response, 404);
            
        } catch (Exception $e) {
            Log::error('Error fetching page details: ' . $e->getMessage());
            $response = ['status' => false, 'message' => 'An error occurred while fetching page details.'];
            
            return response($response, 500);
        }
    }
} -->
