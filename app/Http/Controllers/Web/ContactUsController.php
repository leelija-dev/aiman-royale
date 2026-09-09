<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Services\MetaConversionsService;
use Illuminate\Support\Facades\Log;
class ContactUsController extends Controller
{
    protected MetaConversionsService $metaService;

    public function __construct(MetaConversionsService $metaService)
    {
        $this->metaService = $metaService;
    }
    public function index()
    {
        return view('web.contact-us');
    }


    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'mobile'  => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $validatedData['inquiry_type'] = $validatedData['subject'];
    unset($validatedData['subject']);

    ContactUs::create($validatedData);
    // Meta Lead Tracking
try {
    $extraUserData = [];

    if (!empty($validatedData['email'])) {
        $extraUserData['em'] = [hash('sha256', strtolower(trim($validatedData['email'])))];
    }

    if (!empty($validatedData['mobile'])) {
        $extraUserData['ph'] = [$this->metaService->hashPhone($validatedData['mobile'])];
    }

    $this->metaService->trackLead([
        'form_name' => $validatedData['inquiry_type'] ?? 'Contact Form',
    ], $extraUserData);

    Log::info('Meta Lead event tracked from Contact Us form');
} catch (\Exception $e) {
    Log::error('Meta Lead tracking failed: ' . $e->getMessage());
}
    return response()->json([
        'success' => true,
        'message' => 'Your inquiry has been submitted successfully!'
    ]);
}

    }
