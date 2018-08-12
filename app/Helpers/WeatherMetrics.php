<?php

namespace App\Helpers;

use App\city;
use Illuminate\Support\Facades\Cache;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Illuminate\Support\Facades\Log;

class WeatherMetrics
{
    /**
     * get weather metrics
     *
     * @return mixed
     */
    public static function getMetrics()
    {
        $lang = config('openweathermap.lang');
        $units = config('openweathermap.units');
        $apiKey = config('openweathermap.api_key');
        $minutes = config('openweathermap.cache_time');
        $city = City::all()->first()->name;

        if (!Cache::has('weather_metrics')) {
            $weather = [];
            try {
                $owm = new OpenWeatherMap($apiKey);
                $weather = $owm->getWeather($city, $units, $lang);
            } catch(OWMException $e) {
                Log::error('OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').');
            } catch(\Exception $e) {
                Log::error('General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').');
            }

            if($weather){
                Cache::put('weather_metrics', $weather, $minutes);
            }
        }

        return Cache::get('weather_metrics');
    }

    /**
     * Check if wind speed increased above $windSpeedLimit
     *
     * @param $windSpeed
     * @param $windSpeedLimit
     * @param $lastWindSpeed
     * @return bool
     */
    public static function windSpeedOverLimit($windSpeed, $windSpeedLimit, $lastWindSpeed)
    {
        $overLimit = false;
        if($lastWindSpeed){
            if($windSpeed > $windSpeedLimit && $lastWindSpeed <= $windSpeedLimit ){
                $overLimit = true;
            }
        }

        return $overLimit;
    }

    /**
     * Check if wind speed dropped below $windSpeedLimit
     *
     * @param $windSpeed
     * @param $windSpeedLimit
     * @param $lastWindSpeed
     * @return bool
     */
    public static function windSpeedBelowLimit($windSpeed, $windSpeedLimit, $lastWindSpeed)
    {
        $belowLimit = false;
        if($lastWindSpeed){
            if($windSpeed < $windSpeedLimit && $lastWindSpeed >= $windSpeedLimit ){
                $belowLimit = true;
            }
        }

        return $belowLimit;
    }

    /**
     * Check if wind speed is over limit or below
     *
     * @return array
     */
    public static function checkWindLimit()
    {
        $wind = ['min' => false, 'max' => false];

        $weatherMetrics = self::getMetrics();
        $lastWindSpeed = Cache::get('last_wind_speed');
        $windSpeedLimit = config('openweathermap.wind_speed_limit');
        if($weatherMetrics){
            $windSpeed = $weatherMetrics->wind->speed->getValue();

            // wind speed increased above $windSpeedLimit
            if(WeatherMetrics::windSpeedOverLimit($windSpeed, $windSpeedLimit, $lastWindSpeed)){
                $wind['max'] = true;
            }

            // wind speed dropped below $windSpeedLimit
            if(WeatherMetrics::windSpeedBelowLimit($windSpeed, $windSpeedLimit, $lastWindSpeed)){
                $wind['min'] = true;
            }

            // set previous wind speed value
            Cache::forever('last_wind_speed', $windSpeed);
        }

        return $wind;
    }
}