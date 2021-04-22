<?php

namespace App\Http\Controllers\WEB;

use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    //
//    public function __construct() {
//        $this->middleware('auth');
//    }

    public function profileShow() {
        $user = Auth::user();
        return view('profile.show', ['user'=>[$user]]);
    }
}
