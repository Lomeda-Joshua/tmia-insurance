<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\UserView;

use App\Http\Requests\UpdateAccountRequest;
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
                ->orderBy('User_Level_Description')
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

    public function store(UserDataRequest $request): JsonResponse
    {

        dd($request);
        $data = $request->validated();

        $user = $request->filled('uid')
            ? User::query()->findOrFail($data['uid'])
            : new User();

        $user->Last_Name = strtoupper($data['lname']);
        $user->First_Name = strtoupper($data['fname']);
        $user->Middle_Name = isset($data['mname'])
            ? strtoupper($data['mname'])
            : null;
        $user->Suffix_Name = isset($data['sname'])
            ? strtoupper($data['sname'])
            : null;
        $user->Display_Name = strtoupper($data['dname']);
        $user->Contact_No = $data['contactno'] ?? null;
        $user->Email_Address = $data['email'];
        $user->User_Name = $data['uname'];
        $user->User_Level_ID = $data['ulevel'];
        $user->Active = $data['useractive'];
        $user->Enable2FA = $data['chk2fa'];
        $user->ExpireDate = ! empty($data['pwdexpdate'])
            ? Carbon::createFromFormat('d/m/Y', $data['pwdexpdate'])
                ->toDateString()
            : null;

        if (! empty($data['pword'])) {
            $user->Encrypt_Password = Hash::make($data['pword']);
        }

        if (! $user->exists) {
            $user->Register_Date = now()->toDateString();
            $user->Approved_Date = now()->toDateString();
        }

        $user->save();

        return response()->json([
            'message' => 'User saved successfully.',
            'user_id' => $user->User_ID,
        ]);
    }

    public function destroy(int $userId): JsonResponse
    {
        $user = User::query()->findOrFail($userId);

        abort_if(
            $user->User_ID === auth()->id(),
            422,
            'You cannot delete your own account.'
        );

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }


    // User account settings
    public function account(): View
    {
        $user = auth()->user();

        $userLevel = \App\Models\UserLevel::query()
            ->find($user->User_Level_ID);

        return view('livewire.main.settings.account', [
            'user' => $user,
            'userLevel' => $userLevel,
        ]);
    }

    public function updateAccount(UpdateAccountRequest $request): JsonResponse 
    {
            $user = $request->user();
            $data = $request->validated();

            $user->Last_Name = strtoupper(trim($data['lname']));
            $user->First_Name = strtoupper(trim($data['fname']));

            $user->Middle_Name = !empty($data['mname'])
                ? strtoupper(trim($data['mname']))
                : null;

            $user->Suffix_Name = !empty($data['sname'])
                ? strtoupper(trim($data['sname']))
                : null;

            $user->Display_Name = strtoupper(trim($data['dname']));

            $user->Contact_No = !empty($data['contactno'])
                ? trim($data['contactno'])
                : null;

            $user->Email_Address = trim($data['email']);
            $user->User_Name = trim($data['uname']);

            $user->Enable2FA = !empty($data['chk2fa']);

            $user->ExpireDate = !empty($data['pwdexpdate'])
                ? Carbon::createFromFormat(
                    'd/m/Y',
                    $data['pwdexpdate']
                )->toDateString()
                : null;

            /*
            * Only change the password if the user actually
            * entered a new password.
            */
            if (!empty($data['pword'])) {
                $user->Encrypt_Password = Hash::make($data['pword']);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully.',
            ]);
    }


}
