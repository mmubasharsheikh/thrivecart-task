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
}