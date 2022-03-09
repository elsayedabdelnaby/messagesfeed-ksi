<?php

namespace App\Classes;

use App\Classes\Requests\GetRequest;

class FetchMessagesByGetRequest
{
    public function fetch($url)
    {
        return json_decode(GetRequest::send($url), true)["Entries"]["Entry"];
    }
}
