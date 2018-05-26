<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $noficiationId)
    {
       $noti = $request->user()->notifications()->find($noficiationId);
       $noti->delete();
       return response()->json([
           'message' => 'yes ,it readed and delete',
       ]);

    }
}