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
            ]);

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('button', function (UserView $user): string {
                $id = e($user->User_ID);
                $name = e($user->Full_Name);

                return
                    '<button type="button" class="btn btn-success btn-action btnedit" '
                    . 'data-uid="' . $id . '" title="Edit">'
                    . '<i class="fa fa-edit"></i></button> '

                    . '<button type="button" class="btn btn-success btn-action btndelete" '
                    . 'data-uid="' . $id . '" '
                    . 'data-fullname="' . $name . '" title="Delete">'
                    . '<i class="fa fa-remove"></i></button>';
            })
            ->editColumn('ExpireDate', function (UserView $user): string {
                return $user->ExpireDate
                    ? Carbon::parse($user->ExpireDate)->format('F d, Y')
                    : '';
            })
            ->rawColumns(['button'])
            ->setRowId('User_ID')
            ->make(true);

    }

    public function levels(): JsonResponse
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
