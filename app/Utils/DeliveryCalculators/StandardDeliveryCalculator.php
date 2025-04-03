<?php

namespace App\Utils\DeliveryCalculators;

class StandardDeliveryCalculator implements DeliveryCalculatorInterface
{
    public function __construct(
        private readonly array $rules
    ) {}

    public function calculate(float $subtotal): float
    {
        foreach ($this->rules as $limit => $charge) {
            if ($subtotal < $limit) {
                return $charge;
            }
        }
        return 0.0;
    }
}