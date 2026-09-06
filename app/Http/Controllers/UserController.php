<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\UserView;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;


use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UserDataRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // User settings
    public function index(): View
    {
        return view('livewire.main.settings.users');
    } 

    public function userData(){
       $query = UserView::query()
            ->select([
                'User_ID',
                'Full_Name',
                'User_Name',
                'User_Level_Description',
                'Active',
                'Enable2FA',
                'ExpireDate',
            ])->whereNotNull('User_ID');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('ExpireDate', function ($user): string {
                return $user->ExpireDate 
                    ? Carbon::parse($user->ExpireDate)->format('F d, Y') 
                    : '<span style="color:red"> No Expiry date included </span>';
            })
            ->editColumn('Active', function ($user): string {
                $status = strtoupper(trim((string) $user->Active));
                $badgeClass = ($status === 'YES' || $status === '1') ? 'success' : 'danger';
                return '<span class="badge text-bg-' . $badgeClass . '">' . e($user->Active) . '</span>';
            })
            ->editColumn('Enable2FA', function ($user): string {
                $enabled = strtoupper(trim((string) $user->Enable2FA));
                $badgeClass = ($enabled === 'YES' || $enabled === '1') ? 'info' : 'secondary';
                return '<span class="badge text-bg-' . $badgeClass . '">' . e($user->Enable2FA) . '</span>';
            })
            ->addColumn('button', function ($user): string {
                $uid = e($user->User_ID);
                $fullName = e($user->Full_Name);

                return '<button type="button" class="btn btn-sm btn-success btn-action btnedit me-1" '
                    . 'data-uid="' . $uid . '" data-bs-toggle="tooltip" title="Edit">'
                    . '<i class="fa fa-edit"></i></button>'
                    
                    . '<button type="button" class="btn btn-sm btn-danger btn-action btndelete" '
                    . 'data-uid="' . $uid . '" data-fullname="' . $fullName . '" data-bs-toggle="tooltip" title="Delete">'
                    . '<i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['Active', 'Enable2FA', 'button', 'ExpireDate'])
            ->make(true);

    }

    public function userlevels(): JsonResponse
    {
        return response()->json([
            'data' => \App\Models\UserLevel::query()
                ->orderBy('User_Level_ID')
                ->get([
                    'User_Level_ID',
                    'User_Level_Description',
                ]),
        ]);
    }

    public function show(int $userId): JsonResponse
    {
        $user = User::query()
            ->select([
                'User_ID',
                'Last_Name',
                'First_Name',
                'Middle_Name',
                'Suffix_Name',
                'Display_Name',
                'Contact_No',
                'Email_Address',
                'User_Name',
                'User_Level_ID',
                'Active',
                'Enable2FA',
                'Google2FAKey',
                'ExpireDate',
            ])
            ->findOrFail($userId);

        return response()->json($user);
    }

    // User account settings
    public function account(): View
    {
        $user = Auth::user();

        $userLevel = \App\Models\UserLevel::query()
            ->find($user->User_Level_ID);

        return view('livewire.main.settings.account', [
            'user' => $user,
            'userLevel' => $userLevel,
        ]);
    }

    public function getSessionVariables(): JsonResponse
    {
        return response()->json([
            'userid'     => Session::get('userid'),
            'logname'    => Session::get('logname'),
            'uname'      => Session::get('uname'),
            'ulevel'     => Session::get('ulevel'),
            'regdate'    => Session::get('regdate'),
            'dealercode' => Session::get('dealercode'),
            'signin'     => Session::get('signin', false),
            'signout'    => Session::get('signout', false),
        ]);
    }

    public function getUserProfile(): JsonResponse
    {
        // Auth middleware ensures the user is signed in; retrieve the current user's ID
        $uid = Auth::id();

        if (!$uid) {
            return response()->json(['error' => 'Invalid or missing User ID'], 400);
        }

        $user = UserView::select([
                'User_ID', 'Last_Name', 'First_Name', 'Middle_Name', 
                'Suffix_Name', 'Display_Name', 'Contact_No', 'Email_Address', 
                'User_Name', 'User_Level_Description', 'Active', 
                'Enable2FA', 'Google2FAKey', 'ExpireDate'
            ])
            ->where('User_ID', $uid)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Check if a username is already taken by another user.
     */
    public function checkUsername(Request $request): JsonResponse
    {
        $userId = $request->input('uid');

        // Laravel validates uniqueness directly against the database table
        $validator = \Validator::make($request->all(), [
            'uname' => [
                'required',
                'string',
                Rule::unique('user', 'User_Name')->ignore($userId, 'User_ID'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 1]); // Username exists/taken
        }

        return response()->json(['result' => 0]); // Username available
    }

    public function updateUser(Request $request): JsonResponse 
    {
        $enable2fa = in_array(strtoupper((string) $request->input('chk2fa')), ['YES', 'TRUE', '1', 'ON'], true);
        
        // 1. Validate inputs (replaces manual post variable checks)
        $validated = $request->validate([
            'uid'        => ['required', 'integer'],
            'lname'      => ['required', 'string', 'max:255'],
            'fname'      => ['required', 'string', 'max:255'],
            'mname'      => ['nullable', 'string', 'max:255'],
            'sname'      => ['nullable', 'string', 'max:255'],
            'dname'      => ['required', 'string', 'max:255'],
            'contactno'  => ['nullable', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:255'],
            'uname'      => ['required', 'string', 'max:255'],
            'pword'      => ['nullable', 'string', 'min:8'],
            'pwdexpdate' => ['nullable', 'date'],
            'chk2fa'     => ['nullable'],
        ]);

        try {
            // 2. Prepare payload
            $updateData = [
                'Last_Name'     => $validated['lname'],
                'First_Name'    => $validated['fname'],
                'Middle_Name'   => $validated['mname'] ?? null,
                'Suffix_Name'   => $validated['sname'] ?? null,
                'Display_Name'  => $validated['dname'],
                'User_Name'     => $validated['uname'],
                'Contact_No'    => $validated['contactno'] ?? null,
                'Email_Address' => $validated['email'],
                'Enable2FA'     => $enable2fa ? 'YES' : 'NO',
                'ExpireDate'    => $validated['pwdexpdate'] ?? null,
            ];

            // 3. Conditionally add hashed password if provided
            if ($request->filled('pword')) {
                // Adjust field name to 'password' or 'Encrypt_Password' to match your schema
                $updateData['Encrypt_Password'] = Hash::make($validated['pword']); 
            }

            // 4. Perform Update
            $updated = DB::table('user')
                ->where('User_ID', $validated['uid'])
                ->update($updateData);

            return response()->json([
                'result' => 1,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => 'Database operation failed.',
            ], 500);
        }
    }


    /**
     * Fetch user details by User_ID.
     */
    public function getUserData(Request $request): JsonResponse
    {
        $uid = $request->input('uid');

        if (!$uid) {
            return response()->json(['error' => 'Invalid or missing User ID'], 400);
        }

        $user = UserView::select([
            'User_ID', 'Last_Name', 'First_Name', 'Middle_Name', 'Suffix_Name',
            'Display_Name', 'Contact_No', 'Email_Address', 'User_Name',
            'User_Level_ID', 'Active', 'Dealer_ID', 'Enable2FA',
            'Google2FAKey', 'ExpireDate',
        ])
        ->where('User_ID', $uid)
        ->first();

        if (!$user) {
            return response()->json(['error' => 'No user found for the provided ID.'], 404);
        }

        // Return wrapped in an array to match your legacy JS expectations
        return response()->json([$user]);
    }

    public function saveNewUserData(SaveUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $appMethod = $validated['appmethod'];
        $userId    = $validated['uid'] ?? null;
        $password  = $validated['pword'] ?? null;

        // Base field mapping between POST variables and database columns
        $userData = [
            'Last_Name'     => trim($validated['lname']),
            'First_Name'    => trim($validated['fname']),
            'Middle_Name'   => !empty($validated['mname']) ? trim($validated['mname']) : null,
            'Suffix_Name'   => !empty($validated['sname']) ? trim($validated['sname']) : null,
            'Display_Name'  => trim($validated['dname']),
            'User_Name'     => trim($validated['uname']),
            'Contact_No'    => !empty($validated['contactno']) ? trim($validated['contactno']) : null,
            'Email_Address' => trim($validated['email']),
            'User_Level_ID' => $validated['ulevel'],
            'Active'        => $validated['useractive'],
            'Enable2FA'     => $validated['chk2fa'] ?? 0,
            'ExpireDate'    => !empty($validated['pwdexpdate']) ? $validated['pwdexpdate'] : null,
        ];

        try {
            if ($appMethod === 'N') {
                // New User Creation
                $userData['Encrypt_Password'] = Hash::make($password);
                $userData['Register_Date']    = $validated['regdate'] ?? now();
                $userData['Approved_Date']    = $validated['apprdate'] ?? now();

                DB::table('user')->insert($userData);
            } else {
                // Update User
                if (!empty($password)) {
                    $userData['Encrypt_Password'] = Hash::make($password);
                }

                DB::table('user')
                    ->where('User_ID', $userId)
                    ->update($userData);
            }

            return response()->json(['result' => 1]);

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => 'Database operation failed.',
            ], 500);
        }
    }


    public function deleteUser(Request $request): JsonResponse
    {
        // 1. Sanitize & validate UID input
        $validated = $request->validate([
            'uid' => ['required', 'integer', 'exists:user,User_ID'],
        ]);

        try {
            // 2. Perform deletion using Eloquent
            $deleted = User::where('User_ID', $validated['uid'])->delete();

            return response()->json([
                'result' => $deleted ? 1 : 0,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => 'Database error: ' . $e->getMessage(),
            ]);
        }
    }


}
