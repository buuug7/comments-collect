<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);
        $notification->delete();
        return response()->json([
            'message' => 'Yes, already mark as read',
        ]);
    }
}
