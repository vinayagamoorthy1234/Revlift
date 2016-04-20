<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheckAccounts
{
	protected $level = 'Admin';

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
  		// If the current user's role is not admin, redirect back home
  		if(Auth::user()->role != $this->level) return redirect('dashboard')->with(['failure' => 'You do not have access to this area.']);
      
      return $next($request);
  }
}
