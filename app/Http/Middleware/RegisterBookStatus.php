<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Member;

class RegisterBookStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $name = Auth::user()->name;
        $userId = Auth::user()->id;
        $owner = Team::where('owner', $userId)->first();
        $member = Member::where('user_id', $userId)->first();
        if (!$owner && !$member) {
            return redirect('dashboard');
        }

        return $next($request);
    }
}
