<?php

namespace App\Utils\DeliveryCalculators;

interface DeliveryCalculatorInterface
{
    public function calculate(float $subtotal): float;
}