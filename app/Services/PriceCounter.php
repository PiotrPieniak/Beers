<?php

namespace App\Services;

class PriceCounter
{
    public function getPrice($price, $size)
    {
        preg_match_all('!\d+!', $size, $quantity);
        $pricePerLitre = ($price * 1000) / ($quantity[0][0] * $quantity[0][1]);

        return number_format((float)$pricePerLitre, 2, '.', '');
    }
}