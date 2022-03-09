<?php

require_once("./vendor/autoload.php");

use App\Classes\FetchMessagesByGetRequest;
use App\Classes\Map\GoogleMap;
use App\Classes\String\GetLocationsNamesWithGeometryInfoFromString;
use App\Classes\String\RemoveUselessWords;

// a list of useless words which will removed from the text
$useless_words = [
    ' i ', ' he ', ' she ', ' it ', ' you ', ' they ', ' are ', ' is ', ' am ', ' them ',
    ' this ', ' that ', ' these ', ' those ', ' a ', ' an ', ' the ', ' above ',
    ' under ', ' more', ' many ', ' much ', ' him ', ' here ', ' there ', ' their ', ' very ',
    ' with ', ' from ', ' at ', ' into ', ' during ', ' until ', ' against ', ' among ', ' i\'m ',
    ' throughout ', ' towards ', ' upon ', ' of ', ' to ', ' for ', ' by ', ' about ', ' like ',
    ' through ', ' over ', ' before ', ' after ', ' since ', ' without ', ' next ', ' so ',
    ' will ', ' have ', ' has ', ' old ', ' do ', ' did ', ' does ', ' where ', ' when ',
    ' how ', ' who ', ' which ', ' why ', ' on ', ' people ', ' hot ', ' warm ', ' cold ', '  ',
    ' love ', ' live ', ' yellow ', ' black ', ' green ', ' blue ', ' red ', ' in '
];

// a list of words which can't be location name
$skip_words = [
    'i', 'he', 'she', 'it', 'you', 'they', 'are', 'is', 'am', 'them',
    'this', 'that', 'these', 'those', 'a', 'an', 'the', 'in', 'on', 'above',
    'under', 'more', 'many', 'much', 'him', 'here', 'there', 'their', 'very',
    'with', 'from', 'at', 'into', 'during', 'until', 'against', 'among', 'i\'m',
    'throughout', 'towards', 'upon', 'of', 'to', 'for', 'by', 'about', 'like',
    'through', 'over', 'before', 'after', 'since', 'without', 'next', 'so', ',',
    'will', 'have', 'has', 'old', 'do', 'did', 'does', 'where', 'when', 'how', 'who',
    'which', 'why', 'people', 'hot', 'warm', 'cold', 'love', 'live', 'yellow', 'black',
    'green', 'blue', 'red', ''
];

/**
 * get all sentences from the text file
 */
$messages = (new FetchMessagesByGetRequest)->fetch("./data-feed.json");
$google_map = new GoogleMap("AIzaSyA8YjQ00gET3EIeYOuEbiIbl6VMQTbE8bw");
$remove_useless_words = new RemoveUselessWords($useless_words);
$get_locations_data = new GetLocationsNamesWithGeometryInfoFromString($skip_words, $google_map);
$locations = [];
foreach ($messages as $message) {
    $text = $message['message'];
    $sentences = explode(",", $text);
    foreach($sentences as $sentence){
        $clean_text = $remove_useless_words->process($sentence);
        $locations_data = $get_locations_data->process($clean_text);
        if (count($locations_data)) {
            $locations[] = ["message" => $message, "locations" => $locations_data];
        }
    }
}

echo json_encode($locations);
