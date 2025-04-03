<?php

declare(strict_types=1);

class Basket {
    public function __construct(
        private readonly array $catalogue,
        private readonly array $deliveryRules,
        private readonly array $offers = [],
        private array $items = [],
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
            if ($code === 'R01') {
                $pairCount = intdiv($count, 2);
                $remaining = $count % 2;
                $subtotal += $pairCount * ($price + $price / 2) + $remaining * $price;
            } else {
                $subtotal += $count * $price;
            }
            
            $delivery = array_reduce(
                array_keys($this->deliveryRules),
                fn($carry, $limit) => $subtotal < $limit ? $this->deliveryRules[$limit] : $carry,
                0.0
            );
        }

        return round($subtotal + $delivery, 2);
    }
}