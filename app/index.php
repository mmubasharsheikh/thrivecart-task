<?php

require "Basket.php";
require "Utils/Offers/RedWidgetOffer.php";
require "Utils/DeliveryCalculators/StandardDeliveryCalculator.php";

$catalogue = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95,
];

$deliveryRules = [
    50 => 4.95,
    90 => 2.95,
    PHP_INT_MAX => 0.00,
];

$offers = [
    'R01' => new RedWidgetOffer(),
];

$deliveryCalculator = new StandardDeliveryCalculator($deliveryRules);
$basket = new Basket($catalogue, $deliveryCalculator, $offers);

$basket->add('B01');
$basket->add('B01');
$basket->add('R01');
$basket->add('R01');
$basket->add('R01');

echo "Total: $" . number_format($basket->total(), 2) . "\n";