<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegController extends Controller
{
    public function redirectReg(Request $request)
    {
        return $request;
        return redirect()->route('register', $request);
    }
}
