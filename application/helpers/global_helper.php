<?php

use Application\Facades\Auth;

function myArrayContainsWord(array $myArray, $word) {
    foreach ($myArray as $element) {
        if ($element->title == $word || (!empty($myArray['subs']) && myArrayContainsWord($myArray['subs'], $word))){
            return true;
        }
    }
    return false;
}
