<?php

namespace App\Http\Controllers;

use App\City;
use App\Helpers\Subscriber as SubscriberHelper;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    /**
     * CRON endpoint to sent subscribers wind limit notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function sendWindLimitNotifications()
    {
        return Response::make([
            'notifiedSubscribers' => SubscriberHelper::sendWindLimitNotifications(),
        ]);
    }
}
