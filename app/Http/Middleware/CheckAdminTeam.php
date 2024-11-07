<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->currentTeam && $user->currentTeam->name === 'Admin') {
            return $next($request);
        }

        return redirect('/dashboard-reg-items');
    }
}