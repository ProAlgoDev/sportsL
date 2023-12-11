<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Member;

class ApproveStatus {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $user = Auth::user()->id;
        $teamId = $request->teamId;
        $team = Team::where('teamId', $teamId)->first();
        if(!$team) {
            return back();
        }
        $owner = $team->owner;

        $member = Member::where('user_id', $user)->where('team_id', $team->id)->first();
        if($member && $owner != $user) {
            $approve = $member->approved;
            if($approve == 0) {
                return redirect('account_setting');
            }
        }
        return $next($request);

    }
}
