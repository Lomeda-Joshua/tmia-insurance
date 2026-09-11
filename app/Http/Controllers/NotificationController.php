<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Fetch user notifications based on user level and transaction assignments.
     */
    public function getNotifications(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ulevel = $user->ulevel ?? session('ulevel');
        $userid = $user->User_ID ?? $user->id ?? session('userid');

        // Query Builder for 'INSURANCE STAFF'
        if ($ulevel === 'INSURANCE STAFF') {

            // Subquery 1: Transactions New Business
            $tb = DB::table('transactions_nb')
                ->select('Insurance_No')
                ->where('ISE_No', $userid);

            // Subquery 2: Transactions Renewal Business
            $rb = DB::table('transactions_rb')
                ->select('Insurance_No')
                ->where('ISE_No', $userid);

            // Merge subqueries via UNION
            $assignedTransactions = $tb->union($rb);

            // Main Notification query joining the subqueries
            $notifications = Notification::select([
                    'notifications.ID',
                    'notifications.Insurance_No',
                    'notifications.Title',
                    'notifications.Message',
                    'notifications.Status',
                    'notifications.URL',
                    'notifications.Created_Date',
                ])
                ->joinSub($assignedTransactions, 't', function ($join) {
                    $join->on('notifications.Insurance_No', '=', 't.Insurance_No');
                })
                ->where(function ($query) {
                    $query->where('notifications.Status', 'unread')
                        ->orWhere(function ($q) {
                            $q->where('notifications.Status', 'read')
                              ->whereDate('notifications.Created_Date', '>=', now()->toDateString());
                        });
                })
                ->distinct()
                ->orderBy('notifications.Created_Date', 'desc')
                ->get();

        } else {

            // Standard query for Non-Insurance Staff
            $notifications = Notification::select([
                    'ID',
                    'Insurance_No',
                    'Title',
                    'Message',
                    'Status',
                    'URL',
                    'Created_Date',
                ])
                ->where(function ($query) {
                    $query->where('Status', 'unread')
                        ->orWhere(function ($q) {
                            $q->where('Status', 'read')
                              ->whereDate('Created_Date', '>=', now()->toDateString());
                        });
                })
                ->orderBy('Created_Date', 'desc')
                ->get();
        }

        return response()->json($notifications);
    }
}
