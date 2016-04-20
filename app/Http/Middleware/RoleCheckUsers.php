<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheckUsers
{
	protected $levels = ['Admin', 'Owner', 'Manager'];

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
  		$is_authorized = in_array(Auth::user()->role, $this->levels);
  		if(!$is_authorized) return redirect()->route('dashboard')->with(['failure' => 'You do not have access to this area.']);
      
      return $next($request);
  }
}
