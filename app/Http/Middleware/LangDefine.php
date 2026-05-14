<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class LangDefine
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
        // dd(request()->segment(count(request()->segments()));

        if(request()->segment(count(request()->segments()))=="l=ru"){
          $request->session()->put('locale', 'ru');
          \App::setLocale(session('locale'));
          $url = '';
          for($i=0; $i<count(request()->segments()); $i++){
            $url .= request()->segment($i)."/";
          }
          return redirect($url);
        }elseif(request()->segment(count(request()->segments()))=="l=uz"){
          $request->session()->put('locale', 'uz');
          \App::setLocale(session('locale'));
          $url = '';
          for($i=0; $i<count(request()->segments()); $i++){
            $url .= request()->segment($i)."/";
          }
          return redirect($url);
        }elseif(request()->segment(count(request()->segments()))=="l=en"){
          $request->session()->put('locale', 'en');
          \App::setLocale(session('locale'));
          $url = '';
          for($i=0; $i<count(request()->segments()); $i++){
            $url .= request()->segment($i)."/";
          }
          return redirect($url);
        }

        return $next($request);
    }
}
