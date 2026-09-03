<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    public function show(Request $request)
    {
        // If not locked, return to dashboard
        if (! $request->session()->get('lockscreen', false)) {
            return redirect()->route('dashboard');
        }

        return view('livewire.main.lockscreen');
    }

    public function lock(Request $request)
    {
        $request->session()->put('lockscreen', true);
        return response()->json(['status' => 'locked']);
        
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'txtpword' => ['required', 'string'],
        ]);

    
        if (! Hash::check($request->txtpword, $request->user()->Encrypt_Password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // 1. Clear lock state
        $request->session()->put('lockscreen', false);

        // 2. Forget the unlock URL if it was saved as intended
        $request->session()->forget('url.intended');

        // 3. Redirect directly to dashboard
        return redirect()->route('dashboard');
    }
}
