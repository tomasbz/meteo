<?php

namespace App\Http\Controllers;

use App\city;
use App\subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:subscribers',
        ]);

        $subscriber = new Subscriber();
        $subscriber->name = $request->input('name');
        $subscriber->email = $request->input('email');
        $subscriber->city_id = City::all()->first()->id;
        $subscriber->save();

        return redirect('/')->with('success', 'Thank you for subscribing.');
    }
}
