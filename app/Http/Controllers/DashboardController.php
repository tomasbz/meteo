<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard')->with('weatherMetrics', []);
    }
}
