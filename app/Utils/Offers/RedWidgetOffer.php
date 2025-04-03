<?php

namespace App\Utils\Offers;

class RedWidgetOffer implements OfferInterface
{
    public function apply(string $code, int $count, float $price): float
    {
        if ($code !== 'R01') {
            return $count * $price;
        }

        $pairCount = intdiv($count, 2);
        $remaining = $count % 2;
        return $pairCount * ($price + $price / 2) + $remaining * $price;
    }
}