<?php

interface DeliveryCalculatorInterface
{
    public function calculate(float $subtotal): float;
}