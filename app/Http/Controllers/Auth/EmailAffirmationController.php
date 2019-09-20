<?php

namespace Webdev\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class EmailAffirmationController extends Controller
{
    //
    public function afterRegistration(Request $request){
        //If registration is success we have Session and check it then delete
        if($request->session()->has('login')){
            // Forget a single key...
            $request->session()->forget('login');
            return view('auth.email_notification');
            
        }else{//Otherwise Redirect to main page
            return redirect('/');
        }
    }
}
