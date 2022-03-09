<?php

namespace App\Classes\String;

use App\Classes\String\StringProcessingInterface;

class RemoveUselessWords implements StringProcessingInterface
{
    protected $useless_words = [];

    public function __construct($useless_words)
    {
        $this->useless_words = $useless_words;
    }

    /**
     * @param string take a string and return it in small case and not inculde the useless words
     * @return string
     */
    public function process($string): string
    {
        $lower_case = strtolower($string); // convert string to lower case
        $clean_string = str_replace($this->useless_words, ' ', $lower_case); // remove special words

        // remove new if not exist the new york in the sentence
        if (!strpos(strtolower($string), 'new york')) {
            $clean_string = str_replace(' new ', ' ', $clean_string);
        }
        return $clean_string;
    }
}
