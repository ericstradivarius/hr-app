<?php

namespace App\Http\Middleware;

use App\Optymous\Google2faUserRemember;
use Closure;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class GoogleRememberMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::user()->fa_enabled) {
            $authenticator = app(Authenticator::class)->boot($request);
            $session = session()->get('google2fa');

            if($session['otp_timestamp']) {
                return $next($request);
            } else {
                $cookie2fa = request()->cookie('google2fa');
                if($cookie2fa) {
                    $token = $cookie2fa['rememberToken'];
                    $userTokens = Google2faUserRemember::where('user_id', Auth::user()->id)->pluck('token')->toArray();
                    if(in_array($token, $userTokens)) {
                        return $next($request);
                    }
                }
                return $authenticator->makeRequestOneTimePasswordResponse();
            }
        }
        return $next($request);
    }
}
