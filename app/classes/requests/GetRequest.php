<?php

namespace App\Classes\Requests;

class GetRequest{
    public static function send($url){
        return file_get_contents($url);
    }
}