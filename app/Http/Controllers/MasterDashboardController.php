<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        return view('master.index')->with(compact('title'));
    }
}
