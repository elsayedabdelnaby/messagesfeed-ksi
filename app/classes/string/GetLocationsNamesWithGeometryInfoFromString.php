<?php

namespace App\Classes\String;

use App\Classes\String\StringProcessingInterface;

class GetLocationsNamesWithGeometryInfoFromString implements StringProcessingInterface
{
    protected $skip_words = [];
    protected $google_map;

    public function __construct($skip_words, $google_map)
    {
        $this->skip_words = $skip_words;
        $this->google_map = $google_map;
    }

    /**
     * @param string take a string and return the locations names which exist in this string and
     * the latitude and longtiude to them also
     * @return array|null
     */
    public function process($string): array
    {
        $words = explode(' ', $string);
        $number_of_words = count($words);
        $locations = [];
        for ($index = 0; $index < $number_of_words; $index++) {
            if (in_array($words[$index], $this->skip_words) || is_numeric($words[$index])) {
                // skip the word if exist in the skip words array
                continue;
            }
            $location_name = $words[$index];
            $latitude_longitude = $this->google_map->getLatitudeLongitudeToLocation($location_name);
            if (is_null($latitude_longitude) && isset($words[$index + 1])) {
                $location_name = $words[$index] . '%20' . $words[$index + 1];
                $latitude_longitude = $this->google_map->getLatitudeLongitudeToLocation($location_name);
                $location_name = $words[$index] . ' ' . $words[$index + 1];
            }
            if ($latitude_longitude) {
                $locations[$location_name] = $latitude_longitude;
            }
        }
        return $locations;
    }
}
