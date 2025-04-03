<?php

declare(strict_types=1);

namespace App;

use App\Utils\DeliveryCalculators\DeliveryCalculatorInterface;
use App\Utils\Offers\OfferInterface;
use InvalidArgumentException;

final class Basket
{
    private array $items = [];

    public function __construct(
        private readonly array $catalogue,
        private readonly DeliveryCalculatorInterface $deliveryCalculator,
        private readonly array $offers = [],
    ) {}

    public function add(string $productCode): void
    {
        if (!isset($this->catalogue[$productCode])) {
            throw new InvalidArgumentException("Product code {$productCode} not found in catalogue.");
        }
        $this->items[] = $productCode;
    }

    public function total(): float
    {
        $itemsGrouped = array_count_values($this->items);
        $subtotal = 0.0;

        foreach ($itemsGrouped as $code => $count) {
            $price = $this->catalogue[$code];
            $offer = $this->offers[$code] ?? null;

            if ($offer instanceof OfferInterface) {
                $subtotal += $offer->apply($code, $count, $price);
            } else {
                $subtotal += $count * $price;
            }
        }

        $delivery = $this->deliveryCalculator->calculate($subtotal);

        return round($subtotal + $delivery, 2);
    }
}