<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use App\Models\Application;
use App\Models\JobVacancy;
use App\Models\Service;
use App\Models\ContactReply;
use App\Models\ContactUs;
use App\Models\Invoice;
use App\Models\Bill;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function home()
    {
        // $email        = NewsLetter::all();
        // $application  = Application::all();
        // $vacancy      = JobVacancy::all();
        // $services     = Service::all();
        // $reply        = ContactReply::all();
        // $lead_contact = ContactUs::all();
        // $permission   = Permission::all();
        // $admin        = Admin::all();

        // // ✅ Get today's profit and sales data
        // $todayData = $this->getProfitData('today');

        // return view('Admin.home', [
        //     'email'         => $email,
        //     'application'   => $application,
        //     'vacancy'       => $vacancy,
        //     'service'       => $services,
        //     'reply'         => $reply,
        //     'lead_contact'  => $lead_contact,
        //     'permission'    => $permission,
        //     'admin'         => $admin,
        //     'todayProfit'   => $todayData['total_profit'] ?? 0,
        //     'todaySales'    => $todayData['total_sales'] ?? 0,
        // ]);
        return view('Admin.home');
    }

    public function getDashboardData(Request $request)
    {
        try {
            $period    = $request->input('period', 'today');
            $startDate = $request->input('start_date');
            $endDate   = $request->input('end_date');

            $data = $this->getProfitData($period, $startDate, $endDate);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Dashboard data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard data.',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Main method to get profit/sales data
     */
    private function getProfitData($period, $startDate = null, $endDate = null)
    {
        try {
            $now = now();

            switch ($period) {
                case 'today':
                    $startDate = $now->copy()->startOfDay();
                    $endDate   = $now->copy()->endOfDay();
                    $groupBy   = 'HOUR';
                    $format    = 'h A';
                    $interval  = 1;
                    break;

                case 'week':
                    $startDate = $now->copy()->subWeek()->startOfDay();
                    $endDate   = $now->copy()->endOfDay();
                    $groupBy   = 'DAY';
                    $format    = 'D';
                    $interval  = 1;
                    break;

                case 'month':
                    $startDate = $now->copy()->startOfMonth();
                    $endDate   = $now->copy()->endOfMonth();
                    $groupBy   = 'DAY';
                    $format    = 'M d';
                    $interval  = 1;
                    break;

                case 'year':
                    $startDate = $now->copy()->startOfYear();
                    $endDate   = $now->copy()->endOfYear();
                    $groupBy   = 'MONTH';
                    $format    = 'M Y';
                    $interval  = 1;
                    break;

                case 'custom':
                    if (!$startDate || !$endDate) {
                        throw new \InvalidArgumentException('Please select both start and end dates.');
                    }
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate   = Carbon::parse($endDate)->endOfDay();

                    $daysDiff = $startDate->diffInDays($endDate);
                    if ($daysDiff <= 1) {
                        $groupBy = 'HOUR';
                        $format = 'h A';
                    } elseif ($daysDiff <= 14) {
                        $groupBy = 'DAY';
                        $format = 'M d';
                    } elseif ($daysDiff <= 60) {
                        $groupBy = 'WEEK';
                        $format = 'M d';
                    } else {
                        $groupBy = 'MONTH';
                        $format = 'M Y';
                    }
                    $interval = 1;
                    break;

                default:
                    throw new \InvalidArgumentException('Invalid period specified');
            }

            $salesData  = $this->getSalesData($startDate, $endDate, $groupBy, $format, $interval);
            $profitData = $this->getProfitDataForPeriod($startDate, $endDate, $groupBy, $format, $interval);
            $topProducts = $this->getTopProducts($startDate, $endDate);
            $billsData   = $this->getBillDetails($startDate, $endDate);
            // dd($billsData);

            // ✅ Aggregate totals
            $totalProfit = collect($profitData)->sum('value');
            $totalSales  = collect($salesData)->sum('value');

            $totalPaid = DB::table('payment_history')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('paid_amount') ?? 0;

            $totalDue = max(0, $totalSales - $totalPaid);

            return [
                'labels'        => collect($profitData)->pluck('label')->toArray(),
                'profit'        => collect($profitData)->pluck('value')->toArray(),
                'sales'         => collect($salesData)->pluck('value')->toArray(),
                'total_profit'  => $totalProfit,
                'total_sales'   => $totalSales,
                'total_paid'    => $totalPaid,
                'total_due'     => $totalDue,
                'top_products'  => $topProducts,
                'bills'         => $billsData,
                'stats' => [
                    'total_profit'        => $totalProfit,
                    'total_sales'         => $totalSales,
                    'total_due'           => $totalDue,
                    'total_paid'    => $totalPaid,
                    'total_products_sold' => $topProducts->sum('total_quantity'),
                    'unique_products'     => $topProducts->count(),
                    'top_product'         => optional($topProducts->first())->name ?? 'N/A',
                    'top_product_qty'     => optional($topProducts->first())->total_quantity ?? 0,
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Error in getProfitData: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get sales data
     */
    private function getSalesData($startDate, $endDate, $groupBy, $format, $interval)
    {
        $query = DB::select("
            SELECT 
                DATE_FORMAT(created_at, 
                    CASE 
                        WHEN ? = 'HOUR' THEN '%Y-%m-%d %H:00:00'
                        WHEN ? = 'MONTH' THEN '%Y-%m-01 00:00:00'
                        ELSE '%Y-%m-%d 00:00:00'
                    END
                ) as time_group,
                SUM(total_amount) as total
            FROM invoice
            WHERE created_at BETWEEN ? AND ?
              AND deleted_at IS NULL
            GROUP BY time_group
            ORDER BY time_group ASC
        ", [$groupBy, $groupBy, $startDate, $endDate]);

        return collect($query)->map(function ($item) use ($format) {
            $date = Carbon::parse($item->time_group);
            return [
                'label'     => $date->format($format),
                'timestamp' => $date->timestamp,
                'value'     => (float) $item->total
            ];
        });
    }

    /**
     * ✅ Accurate profit calculation query
     */
    private function getProfitDataForPeriod($startDate, $endDate, $groupBy, $format, $interval)
    {
        $dateFormat = match ($groupBy) {
            'MONTH' => "'%Y-%m-01 00:00:00'",
            'HOUR'  => "'%Y-%m-%d %H:00:00'",
            default => "'%Y-%m-%d 00:00:00'"
        };

        $sql = "
    SELECT 
        DATE_FORMAT(i.created_at, $dateFormat) AS time_group,
        SUM(b.unit_price * b.quantity) AS total_price,
        SUM(
            b.purchase_price * b.quantity
        ) AS total_purchase_amount,
        SUM(
            (b.unit_price * b.quantity)
            - (b.purchase_price * b.quantity)
        ) AS total_profit
    FROM invoice_items b
    JOIN invoice i ON b.invoice_id = i.id
    WHERE i.created_at BETWEEN ? AND ?
      AND i.deleted_at IS NULL
    GROUP BY DATE_FORMAT(i.created_at, $dateFormat)
";


        $params = [$startDate, $endDate];
        $query = DB::select($sql, $params);

        return collect($query)->map(function ($item) use ($format) {
            $date = Carbon::parse($item->time_group);
            //dd($item->total_profit);
            return [
                'label'                => $date->format($format),
                'timestamp'            => $date->timestamp,
                'value'                => (float) ($item->total_profit ?? 0),
                'price_after_discount' => (float) ($item->price_after_discount ?? 0),
                'total_purchase_amount' => (float) ($item->total_purchase_amount ?? 0)
            ];
        });
    }

    /**
     * Top selling products
     */
    private function getTopProducts($startDate, $endDate)
    {
        return DB::table('invoice_items as b')
            ->join('products as p', 'b.product_id', '=', 'p.id')
            ->join('invoice as i', 'b.invoice_id', '=', 'i.id')
            ->leftJoin('product_categories as c', 'p.category_id', '=', 'c.id')
            ->select(
                'p.id',
                'p.name',
                'p.sku',
                'c.name as category_name',
                DB::raw('SUM(b.quantity) as total_quantity'),
                DB::raw('SUM(b.unit_price * b.quantity) as total_sales'),
                DB::raw('SUM(b.unit_price * b.quantity) - SUM(0) as price_after_discount'),
                DB::raw('SUM((b.unit_price - COALESCE((SELECT s.purchase_price FROM stocks s WHERE s.product_id = b.product_id ORDER BY s.id DESC LIMIT 1), 0)) * b.quantity) as total_profit'),
                DB::raw('(SUM(b.unit_price*b.quantity)/SUM(b.quantity)) as unit_price'), // use representative price
                DB::raw('MAX(i.created_at) as last_sold_date') // optional info
            )
            ->whereBetween('i.created_at', [$startDate, $endDate])
            ->whereNull('i.deleted_at')
            ->groupBy('b.product_id', 'p.id', 'p.name', 'p.sku', 'c.name')
            ->orderBy('total_quantity', 'DESC')

            ->get()
            ->map(function ($item) {
                $item->total_sales          = (float) $item->total_sales;
                $item->total_profit         = (float) $item->total_profit;
                $item->item_price           = (float) $item->unit_price;
                $item->price_after_discount = (float) $item->price_after_discount;
                $item->total_quantity       = (int) $item->total_quantity;
                $item->category_name        = $item->category_name ?? 'Uncategorized';
                $item->last_sold_date       = $item->last_sold_date ?? null;
                return $item;
            });
    }


    // private function getBillDetails($startDate, $endDate, $limit = 5)
    // {
    //     return DB::table('invoice as i')
    //         ->join('shops as s', 'i.shop_id', '=', 's.id')
    //         ->select(
    //             'i.id',
    //             'i.created_at',
    //             'i.discount_amount',
    //             's.shop_name',
    //             DB::raw('SUM(b.unit_price * b.quantity) as total_amount'), // Example aggregation from invoice_items
    //             DB::raw('(i.total_amount - i.discount_amount) as payable_amount'),
    //             DB::raw('(i.total_amount - i.paid_amount) as due_amount')

    //         )
    //         ->leftJoin('invoice_items as b', 'i.id', '=', 'b.invoice_id') // Join invoice_items if aggregating
    //         ->whereBetween('i.created_at', [$startDate, $endDate])
    //         ->whereNull('i.deleted_at')
    //         ->groupBy('i.id', 'i.created_at', 'i.discount_amount', 's.shop_name') // Include all non-aggregated columns
    //         ->orderBy('i.created_at', 'DESC') // Order by created_at (or change to total_amount, etc.)
    //         ->limit($limit)
    //         ->get()
    //         ->map(function ($item) {
    //             $item->total_amount = (float) ($item->total_amount ?? 0); // Cast to float, default to 0 if null
    //             $item->discount_amount = (float) ($item->discount_amount ?? 0); // Cast to float
    //             $item->shop_name = $item->shop_name ?? 'Unknown Shop'; // Handle null shop_name
    //             $item->created_at = $item->created_at; // Keep as is or format if needed
    //             return $item;
    //         });
    // }
    private function getBillDetails($startDate, $endDate)
    {
        return DB::table('invoice as i')
            ->join('shops as s', 'i.shop_id', '=', 's.id')
            ->select(
                'i.id',
                'i.created_at',
                //'i.discount_amount',
                'i.total_amount', // Added to SELECT for clarity
                'i.paid_amount',  // Added to SELECT for clarity
                's.shop_name',
                DB::raw('SUM(b.unit_price * b.quantity) as calculated_total_amount'), // Renamed to avoid ambiguity
                DB::raw('(i.total_amount - 0) as payable_amount'),
                DB::raw('((i.total_amount - 0) - i.paid_amount) as due_amount'),
                DB::raw('((i.total_amount - 0) - i.paid_amount) as dues')
            )
            ->leftJoin('invoice_items as b', 'i.id', '=', 'b.invoice_id') // Join invoice_items for aggregation
            ->whereBetween('i.created_at', [$startDate, $endDate])
            ->whereNull('i.deleted_at')
            ->groupBy(
                'i.id',
                'i.created_at',
                //'i.discount_amount',
                'i.total_amount', // Added to GROUP BY
                'i.paid_amount',  // Added to GROUP BY
                's.shop_name'
            )
            ->orderBy('i.created_at', 'DESC')
            ->get()
            ->map(function ($item) {
                $item->calculated_total_amount = (float) ($item->calculated_total_amount ?? 0); // Cast aggregated total to float
                //$item->discount_amount = (float) ($item->discount_amount ?? 0);
                $item->payable_amount = (float) ($item->payable_amount ?? 0); // Cast to float
                $item->due_amount = (float) ($item->due_amount ?? 0); // Cast to float
                $item->shop_name = $item->shop_name ?? 'Unknown Shop';
                $item->created_at = $item->created_at; // Keep as is or format if needed
                $item->dues = $item->dues;
                return $item;
            });
    }
}
