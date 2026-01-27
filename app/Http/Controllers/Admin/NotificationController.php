<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   
public function markAsRead($id)
{

    $notification = Notification::findOrFail($id);

   
    $notification->viewed = 1; //if viewed 
    $notification->save();

    
    return redirect()->route($notification->url);
}
}
