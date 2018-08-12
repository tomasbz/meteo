<?php

namespace App\Http\Controllers;

use App\Helpers\WeatherMetrics;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $formatedMetrics = [];
        $weatherMetrics = WeatherMetrics::getMetrics();
        if($weatherMetrics){
            $formatedMetrics = [
                ['title' => 'City', 'value' => $weatherMetrics->city->name],
                ['title' => 'Temperature', 'value' => $weatherMetrics->temperature],
                ['title' => 'Wind speed', 'value' => $weatherMetrics->wind->speed],
                ['title' => 'Wind direction', 'value' => $weatherMetrics->wind->direction],
            ];
        }

        return view('dashboard')->with('weatherMetrics', $formatedMetrics);
    }
}
