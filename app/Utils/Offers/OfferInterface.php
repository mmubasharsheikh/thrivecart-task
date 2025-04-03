<?php

namespace App\Utils\Offers;

interface OfferInterface
{
    public function apply(string $code, int $count, float $price): float;
}