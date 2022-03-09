<?php

namespace App\Classes\Map;

class GoogleMap
{
    protected $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * return an array of geometry info of the location
     * @param string $location_name
     * @return array|null
     */
    public function getLatitudeLongitudeToLocation($location_name)
    {
        $response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$location_name&key=" . $this->api_key);
        $response = json_decode($response, true);
        if ($response['status'] == 'OK') {
            return $response['results'][0]['geometry']['location'];
        }
        return null;
    }
}
