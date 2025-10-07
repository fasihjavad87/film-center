<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
//    protected function redirectTo(Request $request): ?string
//    {
//        return $request->expectsJson() ? null : route('auth.login'); // یا url('/')
//    }
    public function handle(Request $request, Closure $next): Response
    {
        // اگر کاربر لاگین نیست
        if (auth()->check()) {
            // اگر درخواست AJAX یا Livewire هست
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // redirect به login
            return redirect()->route('login');
        }

        // اگر کاربر لاگین است → ادامه درخواست
        return $next($request);
    }

}
