<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = $request->user()->user_role;

        if ($userRole === UserRole::CUSTOMER->value) {
            return $next($request);
        }

        return redirect('admin/dashboard')->with('success', 'You are not authorized to access that page.');
    }
}
