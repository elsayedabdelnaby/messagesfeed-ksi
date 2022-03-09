<?php

namespace App\Classes\String;

interface StringProcessingInterface
{
    /*
     * @param string $str The text for processing
     * @return string after processing
     */
    public function process($str);
}