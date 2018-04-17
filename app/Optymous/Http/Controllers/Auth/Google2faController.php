<?php

namespace App\Optymous\Http\Controllers\Auth;

use App\Optymous\Google2faUserRemember;
use App\Optymous\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Google2faController extends Controller {

    public function twoFactorAuth(Request $request) {
        $secret = $request->input('one_time_password');
        $valid = app('pragmarx.google2fa')->verifyKey(Auth::user()->google2fa_secret, $secret);

        if($valid) {
            $session = session()->get('google2fa');
            $rememberToken = str_random(16);
            $session['rememberToken'] = $rememberToken;
            Google2faUserRemember::create([
                'admin_id' => Auth::user()->id,
                'token' => $rememberToken
            ]);
            cookie()->queue('google2fa', $session);

            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Invalid code.');
        }
    }
}
