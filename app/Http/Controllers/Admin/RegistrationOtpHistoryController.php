<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationOtpHistory;
class RegistrationOtpHistoryController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $allOtp = RegistrationOtpHistory::when($search, function ($query) use ($search) {
            return $query->where('otp_send_to', 'like', "%{$search}%")
            ->orWhere('otp', 'like', "%{$search}%")
            ->orWhere('created_at', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->orWhere('message', 'like', "%{$search}%")
            ->orWhere('failed_reason', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->paginate(10);
        $totalOtp = RegistrationOtpHistory::count();
        $sentOtp = RegistrationOtpHistory::where('status', 'sent')->count();
        $failedOtp = RegistrationOtpHistory::where('status', 'failed')->count();
        return view('Admin.otp-history.index',compact('allOtp', 'totalOtp', 'sentOtp', 'failedOtp'));
    }
}
