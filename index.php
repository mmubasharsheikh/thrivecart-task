<?php

require __DIR__ . '/vendor/autoload.php';

use App\Utils\Offers\RedWidgetOffer;
use App\Utils\DeliveryCalculators\StandardDeliveryCalculator;
use App\Basket;

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

$args = array_slice($argv, 1);

if (empty($args)) {
    echo "Usage: php index.php B01 R01 R01\n";
    exit(1);
}

foreach ($args as $code) {
    try {
        $basket->add($code);
    } catch (InvalidArgumentException $e) {
        echo "Warning: " . $e->getMessage() . PHP_EOL;
    }
}

echo "Total: $" . number_format($basket->total(), 2) . PHP_EOL;