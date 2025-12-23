<?php

namespace Webkul\SizeChart\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Webkul\SizeChart\Repositories\SizeChartRepository;
use Webkul\Core\Http\Controllers\BackendBaseController;

use Webkul\SizeChart\Repositories\AssignTemplateRepository;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\SizeChart\Datagrids\TemplateDataGrid;


class SizeChartController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $sizechartRepository;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $assignTemplateRepository;

    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * Create a new controller instance.
     *
     * @param Webkul\SizeChart\Repositories\SizeChartRepository   $sizechartRepository
     * @param Webkul\SizeChart\Repositories\AssignTemplateRepository   $assignTemplateRepository
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * 
     * @return void
     */
    public function __construct(
        SizeChartRepository $sizechartRepository,
        AssignTemplateRepository $assignTemplateRepository,
        AttributeRepository $attributeRepository
    ) {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->sizechartRepository = $sizechartRepository;

        $this->assignTemplateRepository = $assignTemplateRepository;

        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    // public function index()
    // {
    //     if (request()->ajax()) {
    //         $datagrid = datagrid(TemplateDataGrid::class);
    //         return $datagrid->process();
    //     }
    //     $records = \Webkul\SizeChart\Models\SizeChart::all();

    //     return view($this->_config['view'], [
    //         'debug_records' => $records // For debugging in the view
    //     ]);
    // }

    // public function index()
    // {
    //     if (request()->ajax() || request()->wantsJson()) {
    //         // return datagrid(TemplateDataGrid::class)->process();
    //         return app(\Webkul\SizeChart\DataGrids\TemplateDataGrid::class)->toJson();
    //     }

    //     return view($this->_config['view']);
    // }

    //  public function index()
    // {
    //     if (request()->ajax()) {
    //         return response()->json([
    //             'records' => [
    //                 [
    //                     'id' => 1,
    //                     'name' => 'Test Configurable Template',
    //                     'type' => 'configurable',
    //                     'created_at' => '2025-12-17 10:00:00',
    //                 ],
    //             ],
    //             'columns' => [
    //                 [
    //                     'index' => 'id',
    //                     'label' => 'ID',
    //                     'type' => 'number',
    //                     'sortable' => true,
    //                     'visibility' => true,
    //                 ],
    //                 [
    //                     'index' => 'name',
    //                     'label' => 'Name',
    //                     'type' => 'string',
    //                     'sortable' => true,
    //                     'visibility' => true,
    //                 ],
    //                 [
    //                     'index' => 'type',
    //                     'label' => 'Type',
    //                     'type' => 'string',
    //                     'sortable' => false,
    //                     'visibility' => true,
    //                 ],
    //                 [
    //                     'index' => 'created_at',
    //                     'label' => 'Created At',
    //                     'type' => 'datetime',
    //                     'sortable' => true,
    //                     'visibility' => true,
    //                 ],
    //             ],
    //             'actions' => [],           // Can be empty
    //             'mass_actions' => [],      // Can be empty
    //             'meta' => [
    //                 'total' => 1,
    //                 'per_page_options' => [10, 20, 30, 50, 100],
    //                 'current_page' => 1,
    //                 'last_page' => 1,
    //                 'from' => 1,
    //                 'to' => 1,
    //                 'primary_column' => 'id',  // This is critical!
    //             ],
    //         ]);
    //     }

    //     return view('sizechart::admin.sizechart.index');
    // }

    // public function index()
    // {
    //     if (request()->ajax()) {
    //         // Debug: Try to get records directly
    //         $records = \DB::table('size_charts')->get();
    //         \Log::info('Direct DB query results', ['count' => $records->count()]);

    //         return datagrid(TemplateDataGrid::class)->process();
    //     }

    //     return view('sizechart::admin.sizechart.index');
    // }

    public function index()
    {
        // Use paginate() instead of get() to get a LengthAwarePaginator instance
        $sizeCharts = \DB::table('size_charts')->paginate(10);

        if (request()->ajax()) {
            return response()->json($sizeCharts);
        }

        return view('sizechart::admin.sizechart.index', compact('sizeCharts'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $type = request('type');

        $attributes = $this->attributeRepository->findWhere(['is_filterable' =>  1]);

        return view($this->_config['view'], compact('type', 'attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function getAll($type)
    {
        $templates = [];

        if ($type == "simple" || $type == "virtual") {

            $templates = $this->sizechartRepository->findWhere(['template_type' =>  'simple']);
        } else if ($type == "configurable") {
            $templates = $this->sizechartRepository->findWhere(['template_type' =>  'configurable']);
        }

        return $templates;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function savedTemp($productId)
    {
        $check = $this->assignTemplateRepository->findOneWhere(['product_id' => $productId]);

        if ($check) {
            $sizeChart = $this->sizechartRepository->findOrFail($check->template_id);
        }

        if ($check) {
            return $sizeChart;
        } else {
            return 0;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function  attributeOptions()
    {
        $availableOptions = [];

        $id = request('attribute-id');

        $attribute = $this->attributeRepository->findOrFail($id);

        if (count($attribute->options)) {
            foreach ($attribute->options as $key => $option) {
                array_push($availableOptions, $option->admin_name);
            }

            $availableOptions = implode(',', $availableOptions);

            return  $response = [
                'status'          => true,
                'customOptionValues' => $availableOptions
            ];
        } else {
            return  $response = [
                'status'          => false,
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(Request $request)
    {
        $imagePath = '';

        $this->validate(request(), [
            'template_type' => 'required',
            'template_name' => 'required',
            'formname'      => 'required',
            'template_code' => ['required', 'unique:size_charts,template_code'],
            'image.*'    => 'required|mimes:jpeg,bmp,png,jpg',
        ]);

        $sizeChart = json_encode(request('formname'));

        if (count(request('formname')) < 2) {
            session()->flash('error', trans('sizechart::app.sizechart.response.atleast-one-row', ['name' => request('template_name')]));

            return redirect()->back();
        }

        if (request('image')) {
            foreach (request('image') as $imageId => $image) {
                $file = 'image.' . $imageId;
                $dir = 'template';

                if (request()->hasFile($file)) {
                    $imagePath = request()->file($file)->store($dir);
                }
            }
        }

        $request->request->remove('formname');
        $request->request->add(['size_chart' => $sizeChart]);
        $request->request->add(['image_path' => $imagePath]);

        $this->sizechartRepository->create(request()->all());

        session()->flash('success', trans('sizechart::app.sizechart.response.create-success', ['name' => request('template_name')]));

        return redirect()->route('sizechart.admin.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // public function edit($id)
    // {
    //     $label = '';

    //     $temp = [];

    //     $counter = 0;

    //     $customOptions = '';

    //     $sizeChart = $this->sizechartRepository->findOrFail($id);

    //     $attributes = $this->attributeRepository->findWhere(['is_filterable' =>  1]);

    //     $data = json_decode($sizeChart->size_chart);

    //     if ($data) {
    //         foreach ($data[0] as $key => $value) {
    //             if ($key == 'label') {
    //                 $label = $value;
    //             } else {
    //                 array_push($temp, $value);
    //             }
    //         }

    //         $customOptions = implode(',', $temp);

    //         array_splice($data, 0, 1);

    //         foreach ($data as $key => $value) {
    //             $data[$key] = (array)$data[$key];
    //             $data[$key]['row'] = ++$counter;
    //         }

    //         $addRows = $data;
    //     } else {
    //         $addRows = [];
    //     }



    //     return view($this->_config['view'], compact('sizeChart', 'customOptions', 'label', 'addRows', 'attributes'));
    // }

    // public function edit($id)
    // {
    //     $sizeChart = \DB::table('size_charts')->find($id);
    //     // dd($sizeChart);
    //     $attributes = $this->attributeRepository->findWhere(['is_filterable' => 1]);

    //     return view('sizechart::admin.sizechart.edit', [
    //         'sizeChart' => $sizeChart,
    //         'attributes' => $attributes,
    //         'label' => $sizeChart->label ?? '',
    //         'customOptions' => json_decode($sizeChart->options ?? '[]', true),
    //         'addRows' => json_decode($sizeChart->rows ?? '[]', true)
    //     ]);
    // }

    // public function edit($id)
    // {
    //     $sizeChart = \DB::table('size_charts')->find($id);

    //     if (!$sizeChart) {
    //         abort(404);
    //     }

    //     $attributes = $this->attributeRepository->findWhere(['is_filterable' => 1]);

    //     // Safely decode JSON fields
    //     $options = json_decode($sizeChart->options ?? '[]', true) ?: [];
    //     $rows = json_decode($sizeChart->rows ?? '[]', true) ?: [];

    //     return view('sizechart::admin.sizechart.edit', [
    //         'sizeChart' => $sizeChart,
    //         'attributes' => $attributes,
    //         'label' => $sizeChart->label ?? '',
    //         'customOptions' => is_array($options) ? $options : [],
    //         'addRows' => is_array($rows) ? $rows : [],
    //     ]);
    // }

//     public function edit($id)
//     {
//         $sizeChart = $this->sizechartRepository->findOrFail($id);

//         $data = json_decode($sizeChart->size_chart, true) ?? [];
// ;
//         if (!empty($data)) {
//             $headers = array_shift($data); // first row
//             $matrix  = array_values($data); // remaining rows
//         } else {
//             $headers = [];
//             $matrix  = [];
//         }

//         return view('sizechart::admin.sizechart.edit', [
//             'sizeChart' => $sizeChart,
//             'headers'   => $headers,
//             'matrix'    => $matrix,
//         ]);
//     }

public function edit($id)
{
    $sizeChart = $this->sizechartRepository->findOrFail($id);
    $data = json_decode($sizeChart->size_chart, true) ?? [];
    
    if (!empty($data)) {
        // The first row should be headers
        $firstRow = reset($data);
        $headers = array_keys($firstRow);
        
        // The entire data is our matrix
        $matrix = $data;
    } else {
        $headers = [];
        $matrix = [];
    }

    return view('sizechart::admin.sizechart.edit', [
        'sizeChart' => $sizeChart,
        'headers'   => $headers,
        'matrix'    => $matrix,
    ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the ID from the route parameter
        $id = $id ?? request('template_id');
        
        if (empty($id)) {
            session()->flash('error', 'Invalid size chart ID');
            return redirect()->back();
        }
        
        $imagePath = '';
        $formData = request('formname');
        $templateName = request('template_name');
        $sizeChart = json_encode($formData);

        if (count($formData) < 2) {
            session()->flash('error', trans('sizechart::app.sizechart.response.atleast-one-row', ['name' => $templateName]));
            print_r("hi");
            die;
            return redirect()->back();
        }

        if (request('images')) {
            foreach (request('images') as $imageId => $image) {
                $file = 'images.' . $imageId;
                $dir = 'template';

                if (request()->hasFile($file)) {
                    $imagePath = request()->file($file)->store($dir);
                    $request->request->add(['image_path' => $imagePath]);
                }
            }
        }

        // Get all request data
        $data = $request->all();

        // Add/update the size_chart field
        $data['size_chart'] = $sizeChart;

        // Remove formname as it's no longer needed
        unset($data['formname']);

        try {
            // Debug: Log the ID and check if it's valid
            \Log::info('Updating size chart with ID: ' . $id);
            \Log::info('All size chart IDs: ' . json_encode(\DB::table('size_charts')->pluck('id')->toArray()));
            
            // Try to find the record first
            $sizeChart = $this->sizechartRepository->find($id);
            \Log::info('Found size chart: ' . json_encode($sizeChart));

            if (!$sizeChart) {
                throw new \Exception('Size chart not found with ID: ' . $id);
            }

            // Update the record
            $updated = $this->sizechartRepository->update($data, $id);

            if ($updated) {
                session()->flash('success', trans('admin::app.response.update-success', ['name' => $templateName]));
                return redirect()->route('sizechart.admin.index');
            }

            throw new \Exception('Failed to update size chart');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sizeChart = $this->sizechartRepository->findOrFail($id);

        try {
            $this->sizechartRepository->delete($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Template']));

            return response()->json(['message' => true], 200);
        } catch (Exception $e) {
            report($e);

            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Template']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Mass Delete the products
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $templateIds = explode(',', request()->input('indexes'));

        foreach ($templateIds as $templateId) {
            $template = $this->sizechartRepository->find($templateId);

            if (isset($template)) {
                $this->sizechartRepository->delete($templateId);
            }
        }

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Template']));

        return redirect()->route($this->_config['redirect']);
    }
}
