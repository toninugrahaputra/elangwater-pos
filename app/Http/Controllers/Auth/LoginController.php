<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
    }

    protected function attemptLogin(Request $request): bool
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember')
        );
    }

    protected function credentials(Request $request): array
    {
        return $request->only('email', 'password');
    }

    public function username(): string
    {
        return 'email';
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        return null;
    }

    public function redirectPath(): string
    {
        return '/';
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function hasTooManyLoginAttempts(Request $request): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->limiterKey($request),
            5
        );
    }

    public function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit(
            $this->limiterKey($request),
            60
        );
    }

    public function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear(
            $this->limiterKey($request)
        );
    }

    protected function limiterKey(Request $request): string
    {
        return Str::lower(
            $request->input('email')
        ).'|'.$request->ip();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn(
            $this->limiterKey($request)
        );

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => "Akun terkunci. Silakan coba lagi setelah {$seconds} detik.",
            ]);
    }
}