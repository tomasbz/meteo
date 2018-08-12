<?php

namespace App\Helpers;

use App\Subscriber as SubscriberModel;
use Illuminate\Support\Facades\Log;

class Subscriber
{
    /**
     * Send wind limit email notifications
     *
     * @return array of subscribers
     */
    public static function sendWindLimitNotifications()
    {
        $notifiedSubscribers = [];
        $windLimit = WeatherMetrics::checkWindLimit();
        $subscribers = SubscriberModel::all();
        if($subscribers){
            foreach ($subscribers as $subscriber){
                $notifiedSubscriber = self::notifyWindLimit($subscriber, $windLimit);
                if($notifiedSubscriber){
                    $notifiedSubscribers[] = $notifiedSubscriber;
                }
            }
        }

        return $notifiedSubscribers;
    }

    /**
     * Send email notification if wind speed limit is over or below limit
     *
     * @param $subscriber
     * @param $windLimit
     * @return bool|subscriber
     */
    private static function notifyWindLimit($subscriber, $windLimit)
    {
        $notified = false;

        if($windLimit['min'] && !$subscriber->wind_min){
            $subscriber->wind_min = true;
            $subscriber->save();
            $notified = $subscriber;
            Log::info('WindSpeed below '.config('openweathermap.wind_speed_limit').'m/s. Subscriber '.$subscriber->email.' has been notified.');
        }

        if($windLimit['max'] && !$subscriber->wind_max){
            $subscriber->wind_max = true;
            $subscriber->save();
            $notified = $subscriber;
            Log::info('WindSpeed above '.config('openweathermap.wind_speed_limit').'m/s. Subscriber '.$subscriber->email.' has been notified.');
        }

        return $notified;
    }
}