<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Refund;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\CashfreeRefundService;

class UserController extends Controller implements HasMiddleware
{
    protected $refundService;

    public function __construct(CashfreeRefundService $refundService)
    {
        $this->refundService = $refundService;
    }
    public static function middleware()
    {
        return [
            new Middleware('permission:view reports', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['delete']),
        ];
    }
    /**
     * @return RedirectResponse $request
     */

    public function index()
    {
        $users = Admin::orderBy('created_at', 'desc')->paginate(10);

        $roles = Role::orderby('name', 'ASC')->get();
        // $rolePermissions = $user->roles->pluck('id')->toArray();

        return view('Admin.user.index', ['users' => $users, 'roles' => $roles]);
    }

    public function create()
    {
        $roles = Role::orderby('name', 'ASC')->get();
        // $rolePermissions = $user->roles->pluck('id')->toArray();
        // $permissions = Permission::all();
        return view("Admin.user.create", [
            'roles' => $roles
        ]);
    }


    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string|unique:admin_users,username',
            'email' => 'required|string|email|unique:admin_users,email',
            'password' => 'required|string|min:6', //|confirmed
            'fname' => 'required|nullable|string',
            'lname' => 'required|nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'array|nullable',

        ]);

        // Prepare data
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_logon' => now(),
            'no_logon' => 0,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address' => '',
            'image' => '',
            'description' => $request->description,
            'created_at' => now(),
            //'modified_on' => now()
        ];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_image'), $filename);
            $data['image'] = $filename;
        }

        // Create user and get the model instance
        $user = Admin::create($data);
        // dd($user->user_id);

        // Assign roles/permissions if using a role system like Spatie
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $name) {
                $user->syncRoles($name);
            }
        }

        return redirect()->route('admin.users.show')
            ->with('success', 'User created successfully!');
    }



    public function edit($id)
    {
        // $role = Role::findOrFail($id);
        // //  dd($page); 
        // return view('Admin.role.edit', compact('role'));

        $user = Admin::findOrFail($id);
        $roles = Role::orderby('name', 'ASC')->get();
        $rolePermissions = $user->roles->pluck('id')->toArray();

        return view('Admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'rolePermissions' => $rolePermissions
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = Admin::findOrFail($id);

        // Validate input
        $request->validate([
            //'username' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            //'password' => 'nullable|string|min:6',
            'description' => 'nullable|string|max:1000',

        ]);


        // $slug = Service::generate_slug($request->page_title);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        //$user->username = $request->username;
        $user->email = $request->email;
        $user->description = $request->description;


        if ($request->hasFile('image')) {
            if (!empty($user->image) && file_exists(public_path('upload_image/' . $user->image))) {
                unlink(public_path('upload_image/' . $user->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_image'), $filename);
            $user->image = $filename;
        }
        // if (!empty($request->password)) {
        // $user->password = Hash::make($request->password);
        // }
        $user->updated_at = now();

        $user->save();
        if (!empty($request->permissions)) {
            $user->syncRoles($request->permissions);
        } else {
            $user->syncRoles([]);
        }
        return redirect()->route('admin.users.show') //Admin.user.index
            ->with('success', 'User updated successfully!');
    }
    public function editPassword($id)
    {
        $user = Admin::findOrFail($id);
        $roles = Role::orderby('name', 'ASC')->get();
        return view('Admin.user.passwordUpdate', compact('user', 'roles'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Admin::findOrFail($id);


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
            //echo "Password is incorrect!";
            //exit();
        }


        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.users.show')->with('success', 'Password updated successfully!');
    }

    public function delete($id)
    {
        try {
            $user = Admin::findOrFail($id);

            // Optional: remove roles (Spatie)
            $user->syncRoles([]);

            $user->delete();

            return redirect()->route('admin.users.show')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.show')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    // public function orderHistory($id){
    //     $user = User::findOrFail($id);

    //     $orders=Order::where('user_id',$id)->with('orderProducts.product')->get();
    //     // print_r($orders);die;
    //     return view('web.order-history',compact('user','orders'));
    // }
    public function orderHistory(Request $request, $id)
    {
        $id = base64_decode($id);
        $user = User::findOrFail($id);
        $query = Order::where('user_id', $id)
            ->with('orderProducts.product')
            ->withCount(['reverseOrders as active_return_requests_count' => function ($q) {
                $q->whereIn('status', ['ready_for_pickup', 'in_transit', 'out_for_delivery']);
            }]);

        //  Search

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereRaw('LOWER(order_status) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereHas('orderProducts.product', function ($p) use ($search) {
                        $p->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('date_filter')) {
            $days = $request->date_filter;
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $orders = $query->latest()->paginate(5, '*', 'page');

        return view('web.order-history', compact('user', 'orders'));
    }

    /**
     * Cancel an order
     */


    // public function cancelOrder(Request $request, $orderId)
    // {
    //     try {
    //         \Log::info('=== CANCEL ORDER DEBUG START ===');
    //         \Log::info('Order ID: ' . $orderId);

    //         // Find the order
    //         $order = Order::find($orderId);
    //         if (!$order) {
    //             \Log::error('Order not found: ' . $orderId);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Order not found.'
    //             ], 404);
    //         }

    //         \Log::info('Order found successfully');
    //         \Log::info('Order ID: ' . $order->id);
    //         \Log::info('Order Status: ' . $order->order_status);
    //         \Log::info('Order User ID: ' . $order->user_id);

    //         // Check authentication
    //         $userId = auth('web')->id();
    //         \Log::info('Auth User ID: ' . $userId);

    //         if (!$userId) {
    //             \Log::error('User not authenticated');
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'User not authenticated.'
    //             ], 401);
    //         }

    //         // Check if order is cancellable
    //         $cancelableStatuses = ['pending', 'confirmed', 'paid'];
    //         if (!in_array($order->order_status, $cancelableStatuses)) {
    //             \Log::error('Order not cancellable. Status: ' . $order->order_status);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Order cannot be cancelled. Current status: ' . $order->order_status
    //             ], 400);
    //         }

    //         // Check if waybill exists and cancel it
    //         $waybillCancelled = false;
    //         $waybillError = null;

    //         if (!empty($order->waybill_number)) {
    //             \Log::info('Waybill number found: ' . $order->waybill_number);

    //             try {
    //                 // Call Delhivery API to cancel waybill
    //                 $waybillCancelled = $this->cancelWaybillWithDelhivery($order->waybill_number);

    //                 if ($waybillCancelled) {
    //                     \Log::info('Waybill cancelled successfully: ' . $order->waybill_number);
    //                 } else {
    //                     \Log::warning('Failed to cancel waybill: ' . $order->waybill_number);
    //                     $waybillError = 'Waybill cancellation failed but order will be cancelled in database.';
    //                 }

    //             } catch (\Exception $e) {
    //                 \Log::error('Exception while cancelling waybill: ' . $e->getMessage());
    //                 $waybillError = 'Error cancelling waybill: ' . $e->getMessage();
    //                 // Continue with database cancellation even if waybill API fails
    //             }
    //         } else {
    //             \Log::info('No waybill number found for this order. Skipping Delhivery API call.');
    //         }

    //         // Update order status in database
    //         \Log::info('Attempting to update order status to cancelled...');
    //         $order->order_status = 'cancelled';
    //         $result = $order->save();

    //         \Log::info('Save result: ' . ($result ? 'SUCCESS' : 'FAILED'));
    //         \Log::info('Updated order status: ' . $order->order_status);

    //         \Log::info('=== CANCEL ORDER DEBUG END ===');

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Order cancelled successfully.',
    //             'order_id' => $order->id,
    //             'waybill_cancelled' => $waybillCancelled,
    //             'waybill_error' => $waybillError,
    //             'debug_info' => [
    //                 'order_status' => $order->order_status,
    //                 'user_id' => $userId,
    //                 'save_result' => $result,
    //                 'waybill_number' => $order->waybill_number,
    //                 'waybill_cancellation_status' => $waybillCancelled
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         \Log::error('=== CANCEL ORDER ERROR ===');
    //         \Log::error('Error Message: ' . $e->getMessage());
    //         \Log::error('Error Code: ' . $e->getCode());
    //         \Log::error('File: ' . $e->getFile());
    //         \Log::error('Line: ' . $e->getLine());
    //         \Log::error('Stack Trace: ' . $e->getTraceAsString());
    //         \Log::error('=== END ERROR ===');

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error cancelling order: ' . $e->getMessage(),
    //             'debug_info' => [
    //                 'file' => $e->getFile(),
    //                 'line' => $e->getLine(),
    //                 'code' => $e->getCode()
    //             ]
    //         ], 500);
    //     }
    // }

    public function cancelOrder(Request $request, $orderId)
    {
        try {
            \Log::info('=== CANCEL ORDER DEBUG START ===');
            \Log::info('Order ID: ' . $orderId);

            // Find the order
            $order = Order::find($orderId);
            if (!$order) {
                \Log::error('Order not found: ' . $orderId);
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.'
                ], 404);
            }

            \Log::info('Order found successfully');
            \Log::info('Order ID: ' . $order->id);
            \Log::info('Order Status: ' . $order->order_status);
            \Log::info('Order Payment Status: ' . $order->payment_status);
            \Log::info('Order Payment Method: ' . $order->payment_method);
            \Log::info('Order Total Amount: ' . $order->total_amount);
            \Log::info('Order User ID: ' . $order->user_id);

            // Check authentication
            $userId = auth('web')->id();
            \Log::info('Auth User ID: ' . $userId);

            if (!$userId) {
                \Log::error('User not authenticated');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ], 401);
            }

            // Check if user owns the order
            if ($order->user_id != $userId) {
                \Log::error('User does not own this order. Order User ID: ' . $order->user_id . ', Auth User ID: ' . $userId);
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to cancel this order.'
                ], 403);
            }

            // Check if order is cancellable
            $cancelableStatuses = ['pending', 'confirmed', 'paid'];
            if (!in_array($order->order_status, $cancelableStatuses)) {
                \Log::error('Order not cancellable. Status: ' . $order->order_status);
                return response()->json([
                    'success' => false,
                    'message' => 'Order cannot be cancelled. Current status: ' . $order->order_status
                ], 400);
            }

            // Check if already cancelled
            if ($order->order_status === 'cancelled') {
                \Log::error('Order already cancelled');
                return response()->json([
                    'success' => false,
                    'message' => 'Order has already been cancelled.'
                ], 400);
            }

            // Get cancellation details from request
            $reason = $request->input('reason', 'Cancelled by customer');
            $comments = $request->input('comments', '');

            \Log::info('Cancellation Reason: ' . $reason);
            \Log::info('Cancellation Comments: ' . $comments);

            // Start database transaction
            DB::beginTransaction();

            try {
                // Check if waybill exists and cancel it
                $waybillCancelled = false;
                $waybillError = null;

                if (!empty($order->waybill_number)) {
                    \Log::info('Waybill number found: ' . $order->waybill_number);

                    try {
                        // Call Delhivery API to cancel waybill
                        $waybillCancelled = $this->cancelWaybillWithDelhivery($order->waybill_number);

                        if ($waybillCancelled) {
                            \Log::info('Waybill cancelled successfully: ' . $order->waybill_number);
                        } else {
                            \Log::warning('Failed to cancel waybill: ' . $order->waybill_number);
                            $waybillError = 'Waybill cancellation failed but order will be cancelled in database.';
                        }
                    } catch (\Exception $e) {
                        \Log::error('Exception while cancelling waybill: ' . $e->getMessage());
                        $waybillError = 'Error cancelling waybill: ' . $e->getMessage();
                        // Continue with database cancellation even if waybill API fails
                    }
                } else {
                    \Log::info('No waybill number found for this order. Skipping Delhivery API call.');
                }

                // Process refund for paid orders
                $refundProcessed = false;
                $refundError = null;
                $refundResult = null;

                // Check if order is paid and eligible for refund
                if ($order->payment_status === 'paid' && $order->payment_method === 'cashfree') {
                    \Log::info('Order is paid. Processing refund...');

                    try {
                        
                        $cashfreeOrderRef = $order->cashfree_order_ref;

                        if (!$cashfreeOrderRef) {
                            $timestamp = strtotime($order->created_at);
                            $cashfreeOrderRef = 'CF_' . $order->id . '_' . $timestamp;

                        
                            \Log::info('Generated Cashfree Order Reference: ' . $cashfreeOrderRef);
                        }

                       
                        if (!$cashfreeOrderRef) {
                            $existingRefund = Refund::where('order_id', $order->id)->first();
                            if ($existingRefund && isset($existingRefund->refund_data['order_id'])) {
                                $cashfreeOrderRef = $existingRefund->refund_data['order_id'];
                                \Log::info('Found Cashfree order reference from refund: ' . $cashfreeOrderRef);
                            }
                        }

                        // If still not found, use a fallback based on the transaction_id
                        if (!$cashfreeOrderRef) {
                            
                            $cashfreeOrderRef = 'CF_' . $order->id . '_' . strtotime($order->created_at);
                            \Log::info('Using fallback Cashfree Order Reference: ' . $cashfreeOrderRef);
                        }

                        \Log::info('Cashfree Order Reference: ' . $cashfreeOrderRef);
                        \Log::info('Refund Amount: ' . $order->total_amount);

                        // Process full refund
                        $refundResult = $this->refundService->processRefund(
                            $cashfreeOrderRef,
                            $order->total_amount,
                            null, // Auto-generate refund ID
                            "Order cancellation - {$reason}",
                            'STANDARD',
                            $order->id
                        );
                        // Store refund record in database
                        $refund = Refund::create([
                            'order_id' => $order->id,

                            // if Cashfree returns refund_id
                            'refund_id' => $refundResult['refund_id']
                                ?? 'REF_' . time() . '_' . $order->id,

                            'cf_refund_id' => $refundResult['cf_refund_id'] ?? null,

                            'cf_payment_id' => $refundResult['payment_id'] ?? null,

                            'amount' => $order->total_amount,

                            'status' => Refund::STATUS_PROCESSING,

                            'reason' => "Order cancellation - {$reason}",

                            'refund_data' => $refundResult,

                            'processed_at' => null,
                        ]);
                        $refundProcessed = true;
                        \Log::info('Refund processed successfully', ['refund_result' => $refundResult]);
                    } catch (\Exception $e) {
                        \Log::error('Refund processing failed: ' . $e->getMessage());
                        $refundError = 'Refund processing failed: ' . $e->getMessage();
                        // Continue with order cancellation even if refund fails
                        // The refund can be processed manually later
                    }
                } else {
                    \Log::info('Order is not paid. No refund needed.');
                    \Log::info('Payment Status: ' . $order->payment_status);
                    \Log::info('Payment Method: ' . $order->payment_method);
                }

                // Update order status in database
                \Log::info('Attempting to update order status to cancelled...');

                $updateData = [
                    'order_status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => $reason,
                    'cancellation_comments' => $comments,
                    'updated_at' => now()
                ];

                // Update refund status if refund was processed
                if ($refundProcessed) {
                    $updateData['refund_status'] = 'processing';
                } elseif ($refundError) {
                    $updateData['refund_status'] = 'failed';
                    $updateData['refund_error'] = $refundError;
                } else {
                    $updateData['refund_status'] = 'not_applicable';
                }

                // Update the order
                $order->update($updateData);

                \Log::info('Order status updated successfully');
                \Log::info('Updated order status: ' . $order->order_status);
                \Log::info('Updated refund status: ' . ($updateData['refund_status'] ?? 'none'));

                // Get the refund record if created
                $refund = Refund::where('order_id', $order->id)
                    ->latest()
                    ->first();

                DB::commit();

                // Prepare response message
                $message = 'Order cancelled successfully.';
                if ($refundProcessed) {
                    $message .= ' Refund is being processed.';
                } elseif ($refundError) {
                    $message .= ' Refund failed: ' . $refundError;
                }

                \Log::info('=== CANCEL ORDER DEBUG END ===');

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'order_id' => $order->id,
                    'waybill_cancelled' => $waybillCancelled,
                    'waybill_error' => $waybillError,
                    'refund_processed' => $refundProcessed,
                    'refund_error' => $refundError,
                    'refund' => $refund,
                    'debug_info' => [
                        'order_status' => $order->order_status,
                        'refund_status' => $order->refund_status,
                        'user_id' => $userId,
                        'waybill_number' => $order->waybill_number,
                        'waybill_cancellation_status' => $waybillCancelled,
                        'payment_status' => $order->payment_status,
                        'payment_method' => $order->payment_method,
                        'cancellation_reason' => $reason,
                        'refund_amount' => $order->total_amount,
                        'cashfree_order_ref' => $cashfreeOrderRef ?? 'not_set'
                    ]
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Database transaction failed: ' . $e->getMessage());
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('=== CANCEL ORDER ERROR ===');
            \Log::error('Error Message: ' . $e->getMessage());
            \Log::error('Error Code: ' . $e->getCode());
            \Log::error('File: ' . $e->getFile());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
            \Log::error('=== END ERROR ===');

            return response()->json([
                'success' => false,
                'message' => 'Error cancelling order: ' . $e->getMessage(),
                'debug_info' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'code' => $e->getCode()
                ]
            ], 500);
        }
    }

    /**
     * Cancel waybill with Delhivery API
     * 
     * @param string $waybillNumber
     * @return bool
     */
    private function cancelWaybillWithDelhivery($waybillNumber)
    {
        try {
            $apiToken = env('DELHIVERY_API_TOKEN'); // Store your API token in .env

            if (empty($apiToken)) {
                \Log::error('Delhivery API token not configured');
                return false;
            }

            $apiUrl = "https://staging-express.delhivery.com/api/p/edit";

            $payload = [
                'waybill' => $waybillNumber,
                'cancellation' => true
            ];

            \Log::info('Delhivery API Request URL: ' . $apiUrl);
            \Log::info('Delhivery API Request Payload: ' . json_encode($payload));

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token ' . $apiToken
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For staging only, enable in production

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            \Log::info('Delhivery API Response HTTP Code: ' . $httpCode);
            \Log::info('Delhivery API Response: ' . $response);

            if ($curlError) {
                \Log::error('Curl Error: ' . $curlError);
                return false;
            }

            // Check if request was successful
            if ($httpCode >= 200 && $httpCode < 300) {
                $responseData = json_decode($response, true);

                // Check if cancellation was successful
                if (isset($responseData['success']) && $responseData['success'] === true) {
                    \Log::info('Waybill cancellation successful');
                    return true;
                } elseif (isset($responseData['cancelled']) && $responseData['cancelled'] === true) {
                    \Log::info('Waybill cancellation successful');
                    return true;
                } elseif (isset($responseData['status']) && $responseData['status'] === 'success') {
                    \Log::info('Waybill cancellation successful');
                    return true;
                } else {
                    \Log::warning('Waybill cancellation API returned unexpected response: ' . json_encode($responseData));
                    // Some APIs return success without explicit success flag
                    // Check if there's any error message
                    if (isset($responseData['message']) && strpos(strtolower($responseData['message']), 'error') !== false) {
                        \Log::error('API Error: ' . $responseData['message']);
                        return false;
                    }
                    // Assume success if no error and response is valid
                    return true;
                }
            } else {
                \Log::error('Delhivery API returned error HTTP code: ' . $httpCode);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Exception in cancelWaybillWithDelhivery: ' . $e->getMessage());
            return false;
        }
    }

    // user customer index page
    public function customer()
    {
        $data = User::orderBy('created_at', 'desc')->paginate(15);
        return view('Admin.customer.index', compact('data'));
    }
}
