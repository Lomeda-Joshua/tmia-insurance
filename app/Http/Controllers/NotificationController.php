<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

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

    public function getInsurancePromisesNotificationd(Request $request)
    {
        // 1. Strong session validation (matching your legacy session keys)
        if (!session()->has(['signin', 'ulevel', 'userid'])) {
            // If this is an API route, you might want to return response()->json(['error' => 'Unauthorized'], 401);
            // Matching your legacy redirect behavior:
            return redirect()->route('401-error');
        }

        $ulevel = session('ulevel');
        $userid = session('userid');

        try {
            $startDate = Carbon::today()->toDateString();
            $endDate = Carbon::today()->addDays(7)->toDateString();

            /**
             * 2. Conditional SQL based on user level
             */
            if ($ulevel === 'INSURANCE STAFF') {
                $sql = "
                    SELECT DISTINCT
                        t.Insurance_No,
                        l.Promised_Pay_Date,
                        c.Full_Name
                    FROM (
                        SELECT Insurance_No, Promised_Pay_Date
                        FROM transactions_nb_call_logs
                        WHERE Promised_Pay_Date BETWEEN ? AND ?

                        UNION

                        SELECT Insurance_No, Promised_Pay_Date
                        FROM transactions_rb_call_logs
                        WHERE Promised_Pay_Date BETWEEN ? AND ?
                    ) l
                    INNER JOIN (
                        SELECT Insurance_No, Customer_No
                        FROM transactions_nb
                        WHERE ISE_No = ?

                        UNION

                        SELECT Insurance_No, Customer_No
                        FROM transactions_rb
                        WHERE ISE_No = ?
                    ) t ON t.Insurance_No = l.Insurance_No
                    LEFT JOIN customer_information c
                        ON t.Customer_No = c.Customer_No
                    ORDER BY l.Promised_Pay_Date ASC
                ";

                $bindings = [
                    $startDate, $endDate,
                    $startDate, $endDate,
                    $userid,
                    $userid,
                ];
            } else {
                $sql = "
                    SELECT DISTINCT
                        t.Insurance_No,
                        l.Promised_Pay_Date,
                        c.Full_Name
                    FROM (
                        SELECT Insurance_No, Promised_Pay_Date
                        FROM transactions_nb_call_logs
                        WHERE Promised_Pay_Date BETWEEN ? AND ?

                        UNION

                        SELECT Insurance_No, Promised_Pay_Date
                        FROM transactions_rb_call_logs
                        WHERE Promised_Pay_Date BETWEEN ? AND ?
                    ) l
                    INNER JOIN (
                        SELECT Insurance_No, Customer_No
                        FROM transactions_nb

                        UNION

                        SELECT Insurance_No, Customer_No
                        FROM transactions_rb
                    ) t ON t.Insurance_No = l.Insurance_No
                    LEFT JOIN customer_information c
                        ON t.Customer_No = c.Customer_No
                    ORDER BY l.Promised_Pay_Date ASC
                ";

                $bindings = [
                    $startDate, $endDate,
                    $startDate, $endDate,
                ];
            }

            /**
             * 3. Execute & return JSON
             */
            $results = DB::select($sql, $bindings);

            return response()->json([
                'promises' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage()
            ], 500);
        }
    }




}
