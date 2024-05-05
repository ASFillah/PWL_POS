<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Welcome to Manager Page']); 
        // return view('manager');
    }
}