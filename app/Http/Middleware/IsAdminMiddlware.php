<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = $request->user()->user_role;

        if (in_array($userRole, [
            UserRole::SUPER_ADMIN->value,
            UserRole::ADMIN->value,
            UserRole::STAFF->value,
        ])) {
            return $next($request);
        }

        return redirect('/customer/dashboard')->with('success', 'You are not authorized to access that page.');
    }
}
