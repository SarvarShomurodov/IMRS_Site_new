<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user() && Auth::user()->isAdmin()){
            return $next($request);
        }elseif(Auth::user() && !Auth::user()->isAdmin()){
          return redirect()
                      ->back()
                      ->withErrors(['message'=>'У вас нет доступа на админ панели'])
                      ->withInput();
        }else{
          return redirect('admin/login');
        }

    }
}
