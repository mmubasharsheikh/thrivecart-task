<?php

require "Basket.php";

$catalogue = [
    'R01' => [
        'name' => 'Red Widget',
        'price' => 32.95
    ],
    'G01' => [
        'name' => 'Green Widget',
        'price' => 24.95
    ],
    'B01' => [
        'name' => 'Blue Widget',
        'price' => 7.95
    ]
];

$deliveryRules = [
    50 => 4.95,
    90 => 2.95,
    PHP_INT_MAX => 0.00,
];

$basket = new Basket($catalogue, $deliveryRules);

$basket->add('B01');
$basket->add('B01');

echo "Total: $" . number_format($basket->total(), 2) . "\n";