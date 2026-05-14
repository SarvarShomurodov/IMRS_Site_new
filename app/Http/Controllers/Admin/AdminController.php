<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LastUpdate;
use Validator;
use Auth;

class AdminController extends Controller
{
    public function index(Request $request){
      $lastupdate = LastUpdate::find(1);
      if($lastupdate){
        $lastupdate->update(['updated_at'=>now()]);
      }else{
        $lastupdate = LastUpdate::create();
      } 
      return view('admin.dashboard');
    }


    public function login(Request $request){
      if($request->isMethod('post')){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
          if(Auth::user()->isAdmin()){
            return redirect('admin');
          }else{
            Auth::logout();
            return redirect('admin/login')
                        ->withErrors(['message'=>'Логин или пароль не верно'])
                        ->withInput();
          }
        }else{
          return redirect('admin/login')
                      ->withErrors(['message'=>'Логин или пароль не верно'])
                      ->withInput();
        }
      }else{
        if(!Auth::user()){
          return view('admin.login');
        }else{
          return redirect('/');
        }
      }
    }
}
