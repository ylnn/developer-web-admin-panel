<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request)
    {

        $token = $request->user()->api_token;
        
        return view('welcome', compact('token'));
    }
}
