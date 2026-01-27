<!-- < ?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Pages;
use App\Models\Testimonial;
use App\Http\Controllers\MethodologyController;
use App\Http\Controllers\AccordianController;
use App\Http\Controllers\Web\FaqController;
use App\Http\Controllers\Web\PageController;


class ServiceController extends Controller
{


    protected $MethodologyController;
    protected $faqController;
    protected $PageController;
    protected $AccordianController;

    public function __construct(MethodologyController $MethodologyController, FaqController $faqController, PageController $PageController, AccordianController $AccordianController)
    {
        $this->MethodologyController = $MethodologyController;
        $this->faqController = $faqController;
        $this->PageController = $PageController;
        $this->AccordianController = $AccordianController;
    }

    public function showService($slug)
    {
        // dd($slug);
        // $pageMeta = $this->PageController->pageMetaSlug($slug);
        $resp = $this->PageController->pageMetaSlug($slug);
        $payload = $resp->getOriginalContent();
        $pageMeta = $payload['status'] ? $payload['data'] : [];

        $components = $this->PageController->showBySlug($slug);
        $faqs = $this->faqController->showBySlug($slug);

        $testimonials = Testimonial::forServiceSlug($slug)->newestFirst()->active()->get();

        $servedIndustries = [];

        $props = [
            'pageMeta' => $pageMeta,
            // 'methodology' => $methodology,
            'servedIndustries' => $servedIndustries,
            'faqs' => $faqs,
            'components' => $components,
            'testimonials' => $testimonials,
            // 'accordian'=>$accordian,
        ];


        switch ($slug) {
            case 'design-and-development':
                $props['methodology'] = $this->MethodologyController->designAndDevelopment();
                
                return view('web.design-and-development', $props);

            case 'design':
                $props['data'] = $this->AccordianController->DesignWhychoseUs();
                
                return view('web.design',$props);

            case 'ui-ux-design':
                $props['data'] = $this->AccordianController->uiuxBenefits(); // Pass accordion data as 'data'
                $props['methodology'] = $this->MethodologyController->uiuxDesign();

                return view('web.ui-ux-design', $props);

            case 'digital-marketing':
                $props['methodology'] = $this->MethodologyController->digitalMarketing();
                
                return view('web.digital-marketing-services', $props);

            case 'search-engine-optimization':
                $props['data'] = $this->AccordianController->SeoWhychoseUs(); // Pass accordion data as 'data'

                return view('web.search-engine-optimization',$props, );
            case 'online-marketing':
                $props['data'] = $this->AccordianController->OnlineWhychoseUs(); // Pass accordion data as 'data'

                return view('web.online-marketing',$props, );

            case 'e-commerce-seo':
                $props['data'] = $this->AccordianController->ecommerceSeoBenefits(); // Pass accordion data as 'data'
                $props['methodology'] = $this->MethodologyController->ecommerceSeo();

                return view('web.e-commerce-seo', $props);
            case 'social-media-marketing':
                $props['data'] = $this->AccordianController->socialMediaServices(); // Pass accordion data as 'data'
                $props['methodology'] = $this->MethodologyController->socialMedia();

                return view('web.social-media-marketing', $props);


            case 'mobile-app':
                return view('web.mobile_app', $props);
                // Add more static view mappings here...
            default:
                return redirect()->route('page.coming-soon');
        }
    }
} -->
